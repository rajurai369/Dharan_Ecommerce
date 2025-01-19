<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category=new Category();
        $category->name=$request->name;
        $category->description=$request->description;
        $category->save();
        return response()->json(['message'=>'Category added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category=Category::find($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category= Category::find($id);
        $category->name=$request->name;
        $category->description=$request->description;
        $category->update();
        return response()->json(['message'=>'Category updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::find($id);
        $category->delete();
        return response()->json(['message'=>'Category is deleted successfully']);
    }
}
