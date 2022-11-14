<?php

namespace App\Http\Controllers;

use App\Models\PackageAddon;
use App\Http\Requests\StorePackageAddonRequest;
use App\Http\Requests\UpdatePackageAddonRequest;

class PackageAddonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePackageAddonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageAddonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PackageAddon  $packageAddon
     * @return \Illuminate\Http\Response
     */
    public function show(PackageAddon $packageAddon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PackageAddon  $packageAddon
     * @return \Illuminate\Http\Response
     */
    public function edit(PackageAddon $packageAddon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePackageAddonRequest  $request
     * @param  \App\Models\PackageAddon  $packageAddon
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageAddonRequest $request, PackageAddon $packageAddon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PackageAddon  $packageAddon
     * @return \Illuminate\Http\Response
     */
    public function destroy(PackageAddon $packageAddon)
    {
        //
    }
}
