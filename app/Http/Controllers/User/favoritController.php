<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class favoritController extends Controller
{
    public function index()
    {
        return view('user.favorit');
    }
}
