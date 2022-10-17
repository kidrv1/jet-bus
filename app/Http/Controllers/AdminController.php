<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bus;
use App\Models\Package;
use App\Models\Booking;
use App\Models\Payment;

use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function home()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name','!=', 'admin');
        })->get();
        return view('admin.home',compact('users'));
    }

    public function findUser(Request $request)
    {
        $user = User::find($request->user_id);
        if( $user->getRoleNames()[0] == 'staff' )
        {
            $user->position = 1;
        }else if( $user->getRoleNames()[0] == 'customer' )
        {
            $user->position = 2;
        }
        
        return response()->json($user);
    }

    public function userApprove($id)
    {
        $user = User::find($id);
        $user->status_id = 2;
        $user->save();
        return back()->with('success','User Approved Successfully');

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
        $user->roles()->detach();


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

        $cover = $request->file('image')->getClientOriginalName();
       
        $url = Storage::putFileAs('public', $request->file('image'),$cover);

        $validatedData['image'] = $url;
        $validatedData['user_id'] = Auth::id();

        Bus::create($validatedData);

        return back()->with('success','Bus Created Successfully');
    }

    public function bookingPayment(Request $request)
    {
        $validatedData = $request->validate([
            'payment_receipt'        =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'book_id'               => 'required'
                
        ]);

        $check_book = Booking::find($request->book_id);

        if($check_book)
        {
            $cover = $request->file('payment_receipt')->getClientOriginalName();
       
            $url = Storage::putFileAs('public', $request->file('payment_receipt'),$cover);

            Payment::create(['payment_receipt'=> $url, 'book_id'=> $validatedData['book_id']]);

            return back()->with('success','Payment Sent Successfully');

        }

        

        

    }

    public function findBooking(Request $request)
    {
        $booked = Payment::where('book_id',$request->book_id)->first();

       $file_name = explode("/",$booked->payment_receipt);
        return response()->json($file_name[1]);
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
        $packages = DB::table('bookings')
                   ->join('packages','packages.id','=','bookings.package_id')
                   ->join('buses','buses.id','=','packages.bus_id')
                   ->join('statuses','statuses.id','=','bookings.status_id')
                   
                   ->select('buses.plate','packages.package_name','packages.inclusion','packages.package_rate','bookings.status_id','bookings.created_at','statuses.name as status_name','bookings.id as booking_id','bookings.booking_date as booking_date','bookings.created_at')
                   ->orderBy('bookings.id','DESC')
                   ->get();
        return view('admin.booking',compact('packages'));
    }

    public function sales()
    {
        if(isset($_GET['from_date']) && isset($_GET['to_date']))
        {
            $from = Carbon::parse($_GET['from_date']);
            $to = Carbon::parse($_GET['to_date']);

             $packages = DB::table('bookings')
               ->join('packages','packages.id','=','bookings.package_id')
               ->join('buses','buses.id','=','packages.bus_id')
               ->join('statuses','statuses.id','=','bookings.status_id')
               ->where('bookings.status_id', 2)
               ->whereBetween('bookings.created_at', [$from, $to])
               ->select('buses.plate','packages.package_name','packages.inclusion','packages.package_rate','bookings.status_id','bookings.created_at','statuses.name as status_name','bookings.id as booking_id','bookings.booking_date as booking_date','bookings.created_at')
               ->get();

        }else 
        {
            $packages = DB::table('bookings')
               ->join('packages','packages.id','=','bookings.package_id')
               ->join('buses','buses.id','=','packages.bus_id')
               ->join('statuses','statuses.id','=','bookings.status_id')
               ->where('bookings.status_id', 2)
               ->select('buses.plate','packages.package_name','packages.inclusion','packages.package_rate','bookings.status_id','bookings.created_at','statuses.name as status_name','bookings.id as booking_id','bookings.booking_date as booking_date','bookings.created_at')
               ->get(); 
        }

        
       

        return view('admin.sales',compact('packages'));
    }

    public function report()
    {
        $graph = DB::table('bookings')
          ->select(DB::raw('DATE_FORMAT(created_at, "%m") as date'), DB::raw('count(*) as views'))
          ->groupBy('date')

          ->get();

          $labels = [];
          $data = [];

          foreach($graph as $g)
          {
            array_push($labels, $g->date);
            array_push($data, $g->views);
          }

          return view('admin.report',compact('labels','data'));


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
            'start_time'      => ['required'],
            'end_time'      => ['required'],
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
                   ->join('buses','buses.id','=','packages.bus_id')
                   ->select('packages.id','packages.package_name','packages.package_rate','packages.inclusion','buses.image','packages.start_time','packages.end_time')
                   ->get();
        return view('admin.customer_packages',compact('packages'));
    }

    public function customer_booking_list()
    {
        $packages = DB::table('bookings')
                   ->join('packages','packages.id','=','bookings.package_id')
                   ->join('buses','buses.id','=','packages.bus_id')
                   ->join('statuses','statuses.id','=','bookings.status_id')
                   ->where('bookings.user_id', Auth::id())
                   ->select('buses.plate','packages.package_name','packages.inclusion','packages.package_rate','bookings.status_id','bookings.created_at','statuses.name as status_name','bookings.id as booking_id','bookings.booking_date as booking_date','bookings.created_at')
                   ->orderBy('bookings.id','desc')
                   ->get();
        return view('admin.customer_booking_list',compact('packages'));
    }

    public function bookingSetDate(Request $request)
    {
        $validatedData = $request->validate([
            'booking_date'      => ['required'],
            'package_id'      => ['required']
            
        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['status_id'] = 1;

        Booking::create($validatedData);

        return back()->with('success','You have Booked Successfully');

    }

    public function bookingCancel($id)
    {
        $check = Booking::where('id',$id)->first();

        if(!$check)
        {
           abort(404);
        }

        $check->update(['status_id'=> 3]);

        return back()->with('success','Booked Canceled Successfully');
    }

    public function bookingApprove($id)
    {
         $check = Booking::where('id',$id)->first();

        if(!$check)
        {
           abort(404);
        }

        $check->update(['status_id'=> 2]);

        return back()->with('success','Booked Approved Successfully');
    }
}
