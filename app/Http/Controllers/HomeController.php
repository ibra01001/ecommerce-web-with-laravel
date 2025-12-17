<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        
        $featuredProducts = Product::orderBy('created_at', 'desc')->take(4)->get();
        $categories = Category::all();

        return view('home', compact('featuredProducts', 'categories'));
    }
}
