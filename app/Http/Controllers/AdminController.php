<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bus;
use App\Models\Package;

use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function home()
    {
        $users = User::with(array('Roles' => function($query) {
            $query->where('name','!=','admin');
        }))
        ->get();
        return view('admin.home',compact('users'));
    }

    public function findUser(Request $request)
    {
        return response()->json(User::find($request->user_id));
    }

    public function findBus(Request $request)
    {
        return response()->json(Bus::find($request->bus_id));
    }

    public function updateUser(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'max:255'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'position' => ['required'],
            'gender' => ['required'],
            'mobile' => ['required']
            
        ]);

        $user = User::find($request->user_id);


        if($validatedData['position'] == 1)
        {
            
            $user->first_name       = strtolower($validatedData['first_name']);
            $user->last_name        = strtolower($validatedData['last_name']);
            $user->gender           = strtolower($validatedData['gender']);
            $user->mobile           = strtolower($validatedData['mobile']);
            $user->email            = $validatedData['email'];
            
            $user->save();

            $user->assignRole('staff');
            
        }else if($validatedData['position'] == 2)
        {
            $user->first_name       = strtolower($validatedData['first_name']);
            $user->last_name        = strtolower($validatedData['last_name']);
            $user->gender           = strtolower($validatedData['gender']);
            $user->mobile           = strtolower($validatedData['mobile']);
            $user->email            = $validatedData['email'];
            
            $user->save();

            $user->assignRole('customer');

        }else {
            return 'Invalid User Type';
        }

        
        return back()->with('success','Updated Successfully');
            
    }

    public function deleteUser(Request $request)
    {
        $find_user = User::find($request->user_id);
        if($find_user)
        {
            $find_user->delete();
        }

        return back()->with('success','Deleted Successfully');
    }

    public function bus()
    {
        $buses = Bus::all();
        return view('admin.bus',compact('buses'));
    }

    public function bus_check(Request $request)
    {

        $validatedData = $request->validate([
            'ac'            => ['required'],
            'image'        =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fuel'            => ['required'],
            'model'            => ['required'],
            'plate'            => ['required'],
            'seaters'            => ['required'],
            
        ]);

        unset($validatedData['image']);

        $cover = $request->file('image')->getClientOriginalName();;
       
        $url = Storage::putFileAs('public', $request->file('image'),$cover);

        $validatedData['image'] = $url;
        $validatedData['user_id'] = Auth::id();

        Bus::create($validatedData);

        return back()->with('success','Bus Created Successfully');
    }

    public function updateBus(Request $request)
    {
        $validatedData = $request->validate([
            'ac'            => ['required'],
            'fuel'            => ['required'],
            'model'            => ['required'],
            'plate'            => ['required'],
            'seaters'            => ['required'],
            
        ]);

        $bus = Bus::find($request->bus_id);

        $bus->update($validatedData);

        return back()->with('success','Bus Updated Successfully');

    }

    public function bookingList()
    {
        return view('admin.booking');
    }

    public function sales()
    {
        return view('admin.sales');
    }

    public function busPackage($id)
    {
        $bus = Bus::find($id);
        $packages = Package::where('bus_id',$id)->get();
        return view('admin.package',compact('packages','bus'));
    }

    public function busPackageCheck(Request $request)
    {
        $validatedData = $request->validate([
            'bus_id'      => ['required'],
            'package_name'      => ['required'],
            'package_rate'     => ['required'],
            'inclusion'        => ['required']
            
        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['inclusion'] = json_encode($validatedData['inclusion']);

        Package::create($validatedData);

        return back()->with('success','Bus Package Created Successfully');
    }

    public function customer_booking_packages()
    {
        $packages = DB::table('packages')
                   ->join('buses','packages.bus_id','=','buses.id')
                   ->get();
        return view('admin.customer_packages',compact('packages'));
    }

    public function customer_booking_list()
    {
        return view('admin.customer_booking_list');
    }
}
