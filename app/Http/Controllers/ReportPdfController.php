<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Status;
use App\Models\Booking;

class ReportPdfController extends Controller
{
    //

    public function LatestUsers($type)
    {

        $users;

        if($type =='daily'){
            $users = User::whereHas('roles', function ($query) {
                $query->where('name',  'customer');
            })->whereMonth('created_at',Carbon::now()->month)->get();
        }
        elseif($type == 'monthly'){
            $users = User::whereHas('roles', function ($query) {
                $query->where('name',  'customer');
            })->whereYear('created_at',Carbon::now()->year)->get();
        }
        else{
            $users = User::whereHas('roles', function ($query) {
                $query->where('name',  'customer');
            })->get();
        }
       

        return view('admin.latestUserPDF',compact('users'));
    }

    public function salesReport($type){

        if($type =='daily'){
           
            $bookings = Booking::with(['parent', "user", "package.bus", "status", "addons", "cancelRequest", "payment"])
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('status_id', Status::COMPLETED)
            ->latest()
            ->get();
            }
        elseif($type == 'monthly'){
           
            $bookings = Booking::with(['parent', "user", "package.bus", "status", "addons", "cancelRequest", "payment"])
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status_id', Status::COMPLETED)
            ->latest()
            ->get();
            }
        else{
           
            $bookings = Booking::with(['parent', "user", "package.bus", "status", "addons", "cancelRequest", "payment"])
           // ->whereBetween('created_at', [$from, $to])
            ->where('status_id', Status::COMPLETED)
            ->latest()
            ->get();
            }

            return view('admin.salesPDF', compact('bookings'));
       
    }
    public function popularReport($type){
        $bookings = Booking::with(["package", "addons"]);
        // ->where("status_id", "!=", Status::CANCELED)

        if($type =='daily'){
            $bookings = $bookings->whereMonth('created_at',Carbon::now()->month);
            }
        elseif($type == 'monthly'){
            $bookings = $bookings->whereYear('created_at', Carbon::now()->year);
            }
        

       

        $bookings = $bookings->get();

        $bookingData = [];
        $bookingAddons = [];

        foreach ($bookings as $booking) {
            // Check if already in array
            if (array_key_exists($booking->package->id, $bookingData)) {
                $bookingData[$booking->package->id]["count"] += 1;
            } else {
                $bookingData[$booking->package->id] = [
                    "package_name" => $booking->package->package_name,
                    "count" => 1,
                    "top_addon" => null,
                    "top_addon_count" => null,
                ];
            }

            // Get Count Of Most Booked Addon
            foreach ($booking->addons as $addon) {
                if (!array_key_exists($addon->booking->package_id, $bookingAddons)) {
                    $bookingAddons[$addon->booking->package_id] = [];
                }
                array_push($bookingAddons[$addon->booking->package_id], $addon->name);
            }
        }

        // Calculate Most Popular Addon
        foreach ($bookingAddons as $idx => $addonArray) {
            $nameCount = array_count_values($addonArray);
            $topAddon = array_keys($nameCount, max($nameCount));
            $bookingData[$idx]["top_addon"] = $topAddon[0];
            $bookingData[$idx]["top_addon_count"] = max($nameCount);
            // dd($idx, $addonArray, $nameCount, $topAddon);
        }

        // Sort By Most Bookings
        usort($bookingData, function ($a, $b) {
            return $b["count"] - $a["count"];
        });

        return view('admin.popularPDF',compact('bookingData'));

    }

    public function LatestUsersXLS($type)
    {

        $users;

        if($type =='daily'){
            $users = User::whereHas('roles', function ($query) {
                $query->where('name',  'customer');
            })->whereMonth('created_at',Carbon::now()->month)->get();
        }
        elseif($type == 'monthly'){
            $users = User::whereHas('roles', function ($query) {
                $query->where('name',  'customer');
            })->whereYear('created_at',Carbon::now()->year)->get();
        }
        else{
            $users = User::whereHas('roles', function ($query) {
                $query->where('name',  'customer');
            })->get();
        }
       

        return view('admin.latestUserXLS',compact('users'));
    }

    public function salesReportXLS($type){

        if($type =='daily'){
           
            $bookings = Booking::with(['parent', "user", "package.bus", "status", "addons", "cancelRequest", "payment"])
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('status_id', Status::COMPLETED)
            ->latest()
            ->get();
            }
        elseif($type == 'monthly'){
           
            $bookings = Booking::with(['parent', "user", "package.bus", "status", "addons", "cancelRequest", "payment"])
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status_id', Status::COMPLETED)
            ->latest()
            ->get();
            }
        else{
           
            $bookings = Booking::with(['parent', "user", "package.bus", "status", "addons", "cancelRequest", "payment"])
           // ->whereBetween('created_at', [$from, $to])
            ->where('status_id', Status::COMPLETED)
            ->latest()
            ->get();
            }

            return view('admin.salesXLS', compact('bookings'));
       
    }
    public function popularReportXLS($type){
        $bookings = Booking::with(["package", "addons"]);
        // ->where("status_id", "!=", Status::CANCELED)

        if($type =='daily'){
            $bookings = $bookings->whereMonth('created_at',Carbon::now()->month);
            }
        elseif($type == 'monthly'){
            $bookings = $bookings->whereYear('created_at', Carbon::now()->year);
            }
        

       

        $bookings = $bookings->get();

        $bookingData = [];
        $bookingAddons = [];

        foreach ($bookings as $booking) {
            // Check if already in array
            if (array_key_exists($booking->package->id, $bookingData)) {
                $bookingData[$booking->package->id]["count"] += 1;
            } else {
                $bookingData[$booking->package->id] = [
                    "package_name" => $booking->package->package_name,
                    "count" => 1,
                    "top_addon" => null,
                    "top_addon_count" => null,
                ];
            }

            // Get Count Of Most Booked Addon
            foreach ($booking->addons as $addon) {
                if (!array_key_exists($addon->booking->package_id, $bookingAddons)) {
                    $bookingAddons[$addon->booking->package_id] = [];
                }
                array_push($bookingAddons[$addon->booking->package_id], $addon->name);
            }
        }

        // Calculate Most Popular Addon
        foreach ($bookingAddons as $idx => $addonArray) {
            $nameCount = array_count_values($addonArray);
            $topAddon = array_keys($nameCount, max($nameCount));
            $bookingData[$idx]["top_addon"] = $topAddon[0];
            $bookingData[$idx]["top_addon_count"] = max($nameCount);
            // dd($idx, $addonArray, $nameCount, $topAddon);
        }

        // Sort By Most Bookings
        usort($bookingData, function ($a, $b) {
            return $b["count"] - $a["count"];
        });

        return view('admin.popularXLS',compact('bookingData'));

    }
}
