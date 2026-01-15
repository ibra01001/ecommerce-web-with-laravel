<?php

namespace App\Http\Controllers;

use App\Models\Terms;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function index()
    {
        $terms = Terms::all();
        return view('terms', compact('terms'));
    }
}
