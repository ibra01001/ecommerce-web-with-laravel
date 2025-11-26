<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string', 
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category added successfully');


        
    }
    public function destroy($id)
    {
        $categories = Category::findOrFail($id);
        $categories->delete();
        return redirect()->route('categories.index')
        ->with('success','Category deleted successfully');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit',compact('category'));
    }

    public function update(Rrquest $request, $id)
    {
        $validated = $request->validate([
            'name' =>'required|string|max:255',
            'description'=>'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category = Category->update($validated);

        return redirecct()->route('categories.index')
        ->with('success','Category  updated successfully');
    }
}

