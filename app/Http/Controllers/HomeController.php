<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPackages = Package::with(['bus'])->get();
        $randomPackages = Package::inRandomOrder()->limit(4)->get();
        $prevPackages = null;

        if (Auth::check()) {
            $prevPackages = Booking::with(["package.bus"])->where("user_id", Auth::id())->limit(4)->get();
        }

        return view('home')->with([
            "featuredPackages" => $featuredPackages ?? [],
            "randomPackages" => $randomPackages ?? [],
            "prevPackages" => $prevPackages ?? [],
        ]);
    }
}