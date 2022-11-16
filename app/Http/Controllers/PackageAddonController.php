<?php

namespace App\Http\Controllers;

use App\Models\PackageAddon;
use App\Http\Requests\StorePackageAddonRequest;
use App\Http\Requests\UpdatePackageAddonRequest;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageAddonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($package_id = null)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
            return back()->with('error', 'Forbbiden');
        }

        $package = Package::with(["addons"])->findOrFail($package_id);

        return view("admin.package_addons")->with([
            "package" => $package
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePackageAddonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageAddonRequest $request)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
            return back()->with('error', 'Forbbiden');
        }

        $package = Package::find($request->package_id);
        if ($package == null) {
            return back()->with('error', 'Package Not Found');
        }

        $addon = PackageAddon::create([
            "package_id" => $request->package_id,
            "name" => $request->name,
            "price" => $request->price,
        ]);

        return back()->with('success', 'Addon Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  interger $addon_id
     * @return \Illuminate\Http\Response
     */
    public function show($addon_id)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
            return response()->json([
                "message" => "Forbidden"
            ], 403);
        }

        $addon = PackageAddon::find($addon_id);
        if ($addon == null) {
            return response()->json([
                "message" => "Addon Not Found"
            ], 404);
        }

        return response()->json([
            "data" => $addon,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePackageAddonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageAddonRequest $request)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
            return back()->with('error', 'Forbbiden');
        }

        $addon = PackageAddon::find($request->addon_id);
        if ($addon == null) {
            return back()->with('error', 'Addon Not Found');
        }

        $addon->name = $request->name;
        $addon->price = $request->price;
        $addon->save();

        return back()->with('success', 'Addon Updated');
    }

    /**
     * Disable the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
            return back()->with('error', 'Forbbiden');
        }

        $addon = PackageAddon::find($request->addon_id);
        if ($addon == null) {
            return back()->with('error', 'Addon Not Found');
        }
        $addon->delete();

        return back()->with('success', 'Addon Removed');
    }
}