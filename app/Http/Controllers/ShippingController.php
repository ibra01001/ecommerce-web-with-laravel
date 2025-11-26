<?php

namespace App\Http\Controllers;
use App\Models\Wilaya;
use App\Models\Commune;


class ShippingController extends Controller
{
    public function index()
    {
        $wilayas = Wilaya::orderBy('code')->get();
        return view("cart.index", compact('wilayas'));
    }
    public function getCommunes($wilaya_id)
    {
        $communes = Commune::where('wilaya_id', $wilaya_id)->orderBy('name')->get();
        return response()->json($communes);
    }
}