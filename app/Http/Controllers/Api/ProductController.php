<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all()->map(function ($product) {
            $product->image = asset($product->image); // Convert image path to full URL
            return $product;
        });

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->slug = Str::slug($request->name); // Use name instead of slug field
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $newName = time() . '_' . $file->getClientOriginalName();
            $file->move('images', $newName);
            $product->image = "images/$newName";
        }

        $product->save();

        // Convert image path to full URL for the response
        $product->image = asset($product->image);

        return response()->json(['message' => 'The product is added successfully', 'product' => $product]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->image = asset($product->image); // Convert image path to full URL
        }

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->name = $request->name;
            $product->description = $request->description;
            $product->slug = Str::slug($request->name); // Use name instead of slug field
            $product->price = $request->price;
            $product->category_id = $request->category_id;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $newName = time() . '_' . $file->getClientOriginalName();
                $file->move('images', $newName);
                $product->image = "images/$newName";
            }

            $product->update();

            // Convert image path to full URL for the response
            $product->image = asset($product->image);

            return response()->json(['message' => 'The product is updated successfully', 'product' => $product]);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        $product->delete();
        return response()->json(['message' => 'The product is deleted successfully']);
    }
    
   
}

