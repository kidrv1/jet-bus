<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        //TODO: Pass Variables To HomePage
        return view('home');
    }
}