<?php

namespace App\Http\Controllers;

use App\Models\Realisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealisationController extends Controller
{
    // ─── Index: List all realisations ─────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Realisation::with('uploader')->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $realisations = $query->get();
        $categories   = Realisation::whereNotNull('category')->distinct()->pluck('category');

        return view('realisations.index', compact('realisations', 'categories'));
    }

    // ─── Download ──────────────────────────────────────────────────────────────
    public function download(Realisation $realisation)
    {
        $user = auth()->user();
        if (!$user->isAdmin()
            && !$user->hasPermission('manage_realisations')
            && !$user->hasPermission('view_realisations')) {
            abort(403, 'Action non autorisée.');
        }

        $path = Storage::disk('public')->path($realisation->file_path);
        $ext  = pathinfo($realisation->file_path, PATHINFO_EXTENSION);
        $name = \Str::slug($realisation->title) . '.' . $ext;

        return response()->download($path, $name);
    }

    // ─── Store: Upload new realisation (admin + agent) ─────────────────────────
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->hasPermission('manage_realisations') && !$user->hasPermission('add_realisations')) {
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'category'    => 'nullable|string|max:100',
            'file'        => 'required|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,mkv,webm|max:102400', // 100MB max
        ]);

        $file = $request->file('file');
        $mime = $file->getMimeType();
        $type = str_starts_with($mime, 'video/') ? 'video' : 'image';

        $path = $file->store('realisations', 'public');

        // Generate thumbnail for videos (just store null — no FFmpeg server-side here)
        $thumbnailPath = null;

        Realisation::create([
            'title'          => $request->title,
            'description'    => $request->description,
            'category'       => $request->category ?: null,
            'type'           => $type,
            'file_path'      => $path,
            'thumbnail_path' => $thumbnailPath,
            'uploaded_by'    => $user->id,
        ]);

        return back()->with('success', 'Réalisation ajoutée avec succès.');
    }

    // ─── Update: Edit title/description/category (admin only) ─────────────────
    public function update(Request $request, Realisation $realisation)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->hasPermission('manage_realisations')) {
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'category'    => 'nullable|string|max:100',
        ]);

        $realisation->update([
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category ?: null,
        ]);

        return back()->with('success', 'Réalisation mise à jour.');
    }

    // ─── Destroy: Delete (admin only) ─────────────────────────────────────────
    public function destroy(Realisation $realisation)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->hasPermission('manage_realisations')) {
            abort(403, 'Action non autorisée.');
        }

        Storage::disk('public')->delete($realisation->file_path);
        if ($realisation->thumbnail_path) {
            Storage::disk('public')->delete($realisation->thumbnail_path);
        }

        $realisation->delete();

        return back()->with('success', 'Réalisation supprimée.');
    }
}
