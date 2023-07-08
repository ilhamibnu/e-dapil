<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caleg;

class LandingController extends Controller
{
    public function index()
    {
        $caleg = Caleg::all();

        return view('landing.pages.index', [
            'caleg' => $caleg
        ]);
    }
}
