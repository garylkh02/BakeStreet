<?php

namespace App\Http\Controllers;

use App\Models\Flavour;

class FlavourController extends Controller
{
    public function index() {
        $flavours = Flavour::all();
        return $flavours;    
}
}
