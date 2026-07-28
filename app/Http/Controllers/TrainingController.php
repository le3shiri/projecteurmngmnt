<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::latest()->get();
        return view('trainings.index', compact('trainings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 10MB max
            'video_url' => 'nullable|url',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('training_docs', 'public');
        }

        Training::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'video_url' => $request->video_url,
        ]);

        return redirect()->route('trainings.index')->with('success', 'Ressource ajoutée au catalogue de formation.');
    }

    public function destroy(Training $training)
    {
        if ($training->file_path) {
            Storage::disk('public')->delete($training->file_path);
        }
        $training->delete();

        return redirect()->route('trainings.index')->with('success', 'Ressource supprimée.');
    }
}
