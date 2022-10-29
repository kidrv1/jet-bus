<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function show(Request $request, $id)
    {
        $package = Package::with(['bus'])->find($id);
        $randomPackages = Package::with(['bus'])
            ->inRandomOrder()
            ->limit(10)
            ->get();

        if ($package == null) {
            return redirect()->route("home");
        }

        $inCart = Cart::where('user_id', auth()->id())
            ->where('package_id', $package->id)
            ->first();

        return view("package.show")->with([
            "randomPackages" => $randomPackages ?? [],
            "package" => $package,
            "inclusions" => json_decode($package->inclusion),
            "inCart" => $inCart ?? null
        ]);
    }
}