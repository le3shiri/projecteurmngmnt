<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $products = Product::with('category')
        ->when($search, function ($q) use ($search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        })
        ->when($category, function ($q) use ($category) {
            $q->where('category_id', $category);
        })
        ->orderBy('name')
        ->paginate(15);

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('products.index', compact('products', 'search', 'category', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'code' => 'required|string|unique:products,code|max:50',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'prix_fournisseur' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

        if (auth()->user()->isAdmin()) {
            $rules['commission_agent'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $categoryName = null;
        if ($request->category_id) {
            $cat = \App\Models\Category::find($request->category_id);
            if ($cat) {
                $categoryName = $cat->name;
            }
        }

        Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'category' => $categoryName,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'prix_fournisseur' => $request->prix_fournisseur,
            'commission_agent' => auth()->user()->isAdmin() ? $request->commission_agent : 0,
            'stock' => $request->stock,
            'image' => $imagePath,
            'is_active' => true,
        ]);

        return redirect()->route('products.index')->with('success', 'Produit ajouté avec succès au catalogue.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'code' => 'required|string|unique:products,code,' . $product->id . '|max:50',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'prix_fournisseur' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

        if (auth()->user()->isAdmin()) {
            $rules['commission_agent'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        $categoryName = null;
        if ($request->category_id) {
            $cat = \App\Models\Category::find($request->category_id);
            if ($cat) {
                $categoryName = $cat->name;
            }
        }

        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'category' => $categoryName,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'prix_fournisseur' => $request->prix_fournisseur,
            'stock' => $request->stock,
        ];

        if (auth()->user()->isAdmin()) {
            $data['commission_agent'] = $request->commission_agent;
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès.');
    }
}
