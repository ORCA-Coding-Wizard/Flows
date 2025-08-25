<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class transaksiController extends Controller
{
       public function index()
    {
        return view('user.transaksi');
    }
}