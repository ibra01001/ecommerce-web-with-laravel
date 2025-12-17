<?php

// app/Http/Controllers/AboutUsController.php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::where('is_active', true)->first();
        return view('about-us', compact('aboutUs'));
    }
}