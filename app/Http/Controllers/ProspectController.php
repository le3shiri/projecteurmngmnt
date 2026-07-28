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

        if ($user->isAdmin()) {
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
            'file' => 'required|file|mimes:csv,txt|max:4096',
        ]);

        $path = $request->file('file')->store('prospect_files', 'public');

        $prospectFile = ProspectFile::create([
            'name' => $request->name,
            'file_path' => $path,
            'agent_id' => $request->agent_id,
            'uploaded_by' => auth()->id(),
        ]);

        // Parse CSV and insert prospects
        $filePath = storage_path('app/public/' . $path);
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Check if there is a header
            $header = fgetcsv($handle, 1000, ',');
            
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                // We assume first column is name, second is phone. Or just phone.
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
            fclose($handle);
        }

        return redirect()->route('prospects.index')->with('success', 'Fichier prospects importé et assigné avec succès.');
    }

    public function show(ProspectFile $file)
    {
        $user = auth()->user();
        if ($user->isAgent() && $file->agent_id !== $user->id) {
            abort(403);
        }

        $prospects = $file->prospects()->paginate(50);
        return view('prospects.show', compact('file', 'prospects'));
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
            'status' => 'required|in:called,interested,not_interested,wrong_number',
            'notes' => 'nullable|string',
        ]);

        $prospect->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'called_at' => now(),
        ]);

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
