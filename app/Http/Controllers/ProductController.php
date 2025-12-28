<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return Inertia::render('Menu/Index', compact('products'));
    }

    public function indexAdmin(){
        $products = Product::all();
        return Inertia::render('Products/Index', compact('products'));
    }

    public function create(){
        return Inertia::render('Products/Create');
    }
    public function store(Request $request){
       $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
       ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->extension();
            $validated['image'] = $file->storeAs('products', $filename, 'public');
        }

        $validated['name'] = $request->input('name');
        $validated['price'] = $request->input('price');
        $validated['description'] = $request->input('description');

        Product::create($validated);
    

       return redirect()->route('products.index')->with('message', 'Product created successfully');

    }

    public function edit(Product $product){
        return inertia::render('Products/Edit', compact('product'));
    }

    public function update(Request $request, Product $product){
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->extension();
            $validated['image'] = $file->storeAs('products', $filename, 'public');
        }
        
        $product->update([
            'name' =>  $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'image' => $request->hasFile('image') ?  $validated['image'] : $product->image,
        ]);

        return redirect()->route('products.index')->with('message', 'Product updated successfully');


    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('products.index')->with('message', 'Product deleted successfully');
    }
    
}