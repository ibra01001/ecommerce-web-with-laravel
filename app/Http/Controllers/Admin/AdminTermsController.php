<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Terms;
use Illuminate\Http\Request;


class AdminTermsController extends Controller
{
    public function index()
    {
        $terms = Terms::all();
        return view('admin.terms.index', compact('terms'));
    }

    public function create()
    {
        return view('admin.terms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Terms::create($request->all());

        return redirect()->route('admin.terms.index')
            ->with('success', 'Terms created successfully!');
    }

    public function edit(Terms $term)
    {
        return view('admin.terms.edit', compact('term'));
    }

    public function update(Request $request, Terms $term)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $term->update($request->all());

        return redirect()->route('admin.terms.index')
            ->with('success', 'Terms updated successfully!');
    }

    public function destroy(Terms $term)
    {
        $term->delete();

        return redirect()->route('admin.terms.index')
            ->with('success', 'Terms deleted successfully!');
    }
}