<?php

namespace App\Http\Controllers;

use App\Models\MobileSuit;
use App\Models\Pilot;

class GundamController extends Controller
{
    public function index()
    {
        $mobileSuits = MobileSuit::with('pilots')->get();
        $pilots = Pilot::with('mobileSuits')->get();

        return view('gundam.index', compact('mobileSuits', 'pilots'));
    }
}