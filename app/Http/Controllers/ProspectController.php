<?php

namespace App\Http\Controllers;

use App\Models\ProspectFile;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProspectController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = ProspectFile::query();

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($user->isAdmin() || $user->hasPermission('manage_prospects')) {
            $files = $query->with(['agent', 'uploader'])->withCount('prospects')->latest()->get();
            $agents = User::where('role', 'agent')->where('is_active', true)->orderBy('name')->get();
            return view('prospects.admin_index', compact('files', 'agents', 'startDate', 'endDate'));
        } else {
            $files = $query->where('agent_id', $user->id)->withCount('prospects')->latest()->get();
            return view('prospects.agent_index', compact('files', 'startDate', 'endDate'));
        }
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'agent_id' => 'required|exists:users,id',
            'file' => 'required|file|max:10240',
        ]);

        $path = $request->file('file')->store('prospect_files', 'public');

        $prospectFile = ProspectFile::create([
            'name' => $request->name,
            'file_path' => $path,
            'agent_id' => $request->agent_id,
            'uploaded_by' => auth()->id(),
        ]);

        // Parse CSV and insert prospects using abstract Storage facade
        if (Storage::disk('public')->exists($path)) {
            $csvContent = Storage::disk('public')->get($path);
            $lines = preg_split('/\r\n|\r|\n/', $csvContent);
            
            // Filter out empty lines
            $lines = array_values(array_filter($lines, function ($line) {
                return trim($line) !== '';
            }));
            
            if (count($lines) > 0) {
                // Auto-detect delimiter (, or ;)
                $delimiter = (strpos($lines[0], ';') !== false) ? ';' : ',';
                
                // Smart header detection (check if line 1 contains text header labels)
                $firstData = str_getcsv($lines[0], $delimiter);
                $col1 = strtolower(trim($firstData[0] ?? ''));
                $col2 = strtolower(trim($firstData[1] ?? ''));
                
                if (in_array($col1, ['nom', 'name', 'prospect', 'full name', 'fullname']) || in_array($col2, ['phone', 'telephone', 'téléphone', 'tel', 'mobile', 'numéro', 'numero'])) {
                    array_shift($lines);
                }
                
                foreach ($lines as $line) {
                    $data = str_getcsv($line, $delimiter);
                    $name = $data[0] ?? 'Prospect';
                    $phone = $data[1] ?? ($data[0] ?? null);
                    
                    if ($phone) {
                        Prospect::create([
                            'prospect_file_id' => $prospectFile->id,
                            'name' => trim($name),
                            'phone' => trim($phone),
                            'status' => 'pending',
                        ]);
                    }
                }
            }
        }

        return redirect()->route('prospects.index')->with('success', 'Fichier prospects importé et assigné avec succès.');
    }

    public function show(ProspectFile $file, Request $request)
    {
        $user = auth()->user();
        if ($user->isAgent() && $file->agent_id !== $user->id) {
            abort(403);
        }

        $search = $request->input('search');
        $status = $request->input('status');

        $query = $file->prospects();

        if ($search) {
            $query->where(function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $prospects = $query->paginate(50)->withQueryString();

        // Calculate statistics
        $stats = [
            'total' => $file->prospects()->count(),
            'pending' => $file->prospects()->where('status', 'pending')->count(),
            'called' => $file->prospects()->where('status', '!=', 'pending')->count(),
            'interested' => $file->prospects()->where('status', 'interested')->count(),
            'not_interested' => $file->prospects()->where('status', 'not_interested')->count(),
            'wrong_number' => $file->prospects()->where('status', 'wrong_number')->count(),
        ];

        return view('prospects.show', compact('file', 'prospects', 'search', 'status', 'stats'));
    }

    public function dialer(ProspectFile $file)
    {
        $user = auth()->user();
        if ($user->isAgent() && $file->agent_id !== $user->id) {
            abort(403);
        }

        // Get the first pending prospect in this file
        $currentProspect = $file->prospects()->where('status', 'pending')->first();

        // Get count stats
        $total = $file->prospects()->count();
        $called = $file->prospects()->where('status', '!=', 'pending')->count();
        $interested = $file->prospects()->where('status', 'interested')->count();

        return view('prospects.dialer', compact('file', 'currentProspect', 'total', 'called', 'interested'));
    }

    public function updateProspect(Request $request, Prospect $prospect)
    {
        $request->validate([
            'status' => 'required|in:pending,called,interested,not_interested,wrong_number',
            'notes' => 'nullable|string',
        ]);

        $prospect->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'called_at' => now(),
        ]);

        $referer = $request->header('referer');
        if ($request->has('redirect_back') || ($referer && !str_contains($referer, '/dialer'))) {
            return back()->with('success', 'Fiche prospect mise à jour avec succès.');
        }

        return redirect()->route('prospects.dialer', $prospect->prospect_file_id)
            ->with('success', 'Statut du prospect mis à jour.');
    }

    public function destroyFile(ProspectFile $file)
    {
        if ($file->file_path) {
            Storage::disk('public')->delete($file->file_path);
        }
        $file->delete();

        return redirect()->route('prospects.index')->with('success', 'Fichier de prospects supprimé.');
    }
}
