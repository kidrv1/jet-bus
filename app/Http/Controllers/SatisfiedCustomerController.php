<?php

namespace App\Http\Controllers;

use App\Models\SatisfiedCustomer;
use App\Http\Requests\StoreSatisfiedCustomerRequest;
use App\Http\Requests\UpdateSatisfiedCustomerRequest;
use Illuminate\Http\Request;

class SatisfiedCustomerController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
            return back()->with('error', 'Forbbiden');
        }

        $testimonials = SatisfiedCustomer::all();

        return view("admin.testimonials")->with(["testimonials" => $testimonials]);
    }

    public function store(StoreSatisfiedCustomerRequest $request)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
            return back()->with('error', 'Forbbiden');
        }

        try {
            $newImageName = uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('testimonials'), $newImageName);

            SatisfiedCustomer::create([
                "image" => $newImageName
            ]);
        } catch (\Throwable $th) {
            return back()->with('error', 'Unexpected Error, Unable To Save Image');
        }

        return back()->with('success', 'Image Saved');
    }

    public function destroy(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'staff'])) {
            return back()->with('error', 'Forbbiden');
        }

        $image = SatisfiedCustomer::find($request->image_id);
        if ($image == null) {
            return back()->with('error', 'Image Not Found');
        }
        $image->delete();
        return back()->with('success', 'Image Removed');
    }
}