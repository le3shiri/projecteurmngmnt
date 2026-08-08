<?php

namespace App\Http\Controllers;

use App\Models\CompanyDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyDocumentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $documents = CompanyDocument::with('uploader')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($category, function ($q) use ($category) {
                $q->where('category', $category);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = [
            'Juridique & Administrative',
            'Finances & Banques',
            'Fiscalité & Taxes',
            'Contrats & Partenariats',
            'Ressources Humaines',
            'Autre'
        ];

        return view('company_documents.index', compact('documents', 'search', 'category', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,csv,jpg,jpeg,png,webp,zip,rar,7z,txt|max:25600',
        ], [
            'title.required' => 'Le titre du document est obligatoire.',
            'file.required' => 'Veuillez joindre un fichier.',
            'file.max' => 'Le fichier ne doit pas dépasser 25 MB.',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('company_documents', 'public');
        $fileType = strtolower($file->getClientOriginalExtension());
        $fileSize = $file->getSize();

        CompanyDocument::create([
            'title' => $request->title,
            'category' => $request->category ?: 'Autre',
            'description' => $request->description,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('company_documents.index')->with('success', 'Document officiel ajouté avec succès.');
    }

    public function update(Request $request, CompanyDocument $companyDocument)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv,jpg,jpeg,png,webp,zip,rar,7z,txt|max:25600',
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category ?: 'Autre',
            'description' => $request->description,
        ];

        if ($request->hasFile('file')) {
            if ($companyDocument->file_path) {
                Storage::disk('public')->delete($companyDocument->file_path);
            }
            $file = $request->file('file');
            $data['file_path'] = $file->store('company_documents', 'public');
            $data['file_type'] = strtolower($file->getClientOriginalExtension());
            $data['file_size'] = $file->getSize();
        }

        $companyDocument->update($data);

        return redirect()->route('company_documents.index')->with('success', 'Document mis à jour avec succès.');
    }

    public function destroy(CompanyDocument $companyDocument)
    {
        if ($companyDocument->file_path) {
            Storage::disk('public')->delete($companyDocument->file_path);
        }
        $companyDocument->delete();

        return redirect()->route('company_documents.index')->with('success', 'Document supprimé avec succès.');
    }
}
