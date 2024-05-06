<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('created_at')->simplePaginate(5);
        return view('user.category.list', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();

        // Create a new category using the validated data
        $category = Category::create([

            'name' => $validatedData['name'],
            'tax_percentage' => $validatedData['tax_percentage'],

        ]);

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('user.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $category = Category::findOrFail($id);

        // Update category using the validated data
        $category->update([
            'name' => $validatedData['name'],
            'tax_percentage' => $validatedData['tax_percentage'],
        ]);

        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
 
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
