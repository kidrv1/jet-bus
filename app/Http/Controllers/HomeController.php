<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\SatisfiedCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPackages = Package::with(['bus'])->where("isActive", true)->get();
        $randomPackages = Package::inRandomOrder()->where("isActive", true)->limit(4)->get();
        $testimonials = SatisfiedCustomer::all();
        $prevPackages = null;

        if (Auth::check()) {
            $prevPackages = Booking::with(["package.bus"])->where("user_id", Auth::id())->limit(4)->get();
        }

        return view('home')->with([
            "featuredPackages" => $featuredPackages ?? [],
            "randomPackages" => $randomPackages ?? [],
            "prevPackages" => $prevPackages ?? [],
            "testimonials" => $testimonials ?? [],
        ]);
    }

    public function services()
    {
        return view("services");
    }
}