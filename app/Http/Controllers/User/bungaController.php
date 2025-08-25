<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class bungaController extends Controller
{
       public function index()
    {
        return view('user.bunga');
    }
}
