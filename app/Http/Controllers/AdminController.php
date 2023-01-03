<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bus;
use App\Models\User;
use App\Models\Status;
use App\Models\Booking;
use App\Models\Package;

use App\Models\Payment;
use Carbon\CarbonPeriod;
use App\Models\BookingAddon;
use Illuminate\Http\Request;
use App\Service\NotifService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            $query->where('name', '!=', 'admin');
        })->get();
        return view('admin.home', compact('users'));
    }

    public function findUser(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user->getRoleNames()[0] == 'staff') {
            $user->position = 1;
        } else if ($user->getRoleNames()[0] == 'customer') {
            $user->position = 2;
        }

        return response()->json($user);
    }

    public function userApprove($id)
    {
        $user = User::find($id);
        $user->status_id = 2;
        $user->save();
        return back()->with('success', 'User Approved Successfully');
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


        if ($validatedData['position'] == 1) {

            $user->first_name       = strtolower($validatedData['first_name']);
            $user->last_name        = strtolower($validatedData['last_name']);
            $user->gender           = strtolower($validatedData['gender']);
            $user->mobile           = strtolower($validatedData['mobile']);
            $user->email            = $validatedData['email'];

            $user->save();

            $user->assignRole('staff');
        } else if ($validatedData['position'] == 2) {
            $user->first_name       = strtolower($validatedData['first_name']);
            $user->last_name        = strtolower($validatedData['last_name']);
            $user->gender           = strtolower($validatedData['gender']);
            $user->mobile           = strtolower($validatedData['mobile']);
            $user->email            = $validatedData['email'];

            $user->save();

            $user->assignRole('customer');
        } else {
            return 'Invalid User Type';
        }


        return back()->with('success', 'Updated Successfully');
    }

    public function deleteUser(Request $request)
    {
        $find_user = User::find($request->user_id);
        if ($find_user) {
            // $find_user->delete();
            $find_user->status_id = Status::PENDING;
            $find_user->save();
        }

        return back()->with('success', 'User Deactivated Successfully');
    }

    public function bus()
    {
        $buses = Bus::all();
        return view('admin.bus', compact('buses'));
    }

    public function busUpdateStatus(Request $request)
    {
        $request->validate([
            "bus_id" => ["required"],
            "status" => ["required", "boolean"]
        ]);

        $bus = Bus::findOrFail($request->bus_id);
        $bus->isActive = $request->status;
        $bus->save();

        if ($request->status == false) {
            Package::where("bus_id", $bus->id)->update([
                "isActive" => false
            ]);
        }

        return back()->with("success", "Bus status updated");
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

        // $cover = $request->file('image')->getClientOriginalName();
        // $url = Storage::putFileAs('public', $request->file('image'), $cover);

        $destinationPath = 'public';
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $fileName = rand(111111111, 999999999) . '.' . $extension;
        $file->move($destinationPath, $fileName);

        $validatedData['image'] = $fileName;
        $validatedData['user_id'] = Auth::id();

        Bus::create($validatedData);

        return back()->with('success', 'Bus Created Successfully');
    }

    public function bookingPayment(Request $request)
    {
        $validatedData = $request->validate([
            'payment_receipt'        =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'book_id'               => 'required'
        ]);

        $check_book = Booking::find($request->book_id);

        if ($check_book) {
            // $cover = $request->file('payment_receipt')->getClientOriginalName();

            // $url = Storage::putFileAs('public', $request->file('payment_receipt'), $cover);
            $destinationPath = 'public';
            $file = $request->file('payment_receipt');
            $extension = $file->getClientOriginalExtension();
            $fileName = rand(111111111, 999999999) . '.' . $extension;
            $file->move($destinationPath, $fileName);

            Payment::create(['payment_receipt' => $fileName, 'book_id' => $validatedData['book_id']]);

            return back()->with('success', 'Payment Sent Successfully');
        }
    }

    public function findBooking(Request $request)
    {
        $booked = Payment::where('book_id', $request->book_id)->first();
        if ($booked) {
            $file_name = $booked->payment_receipt;
            return response()->json($file_name);
        } else {
            return response()->json("null");
        }
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

        return back()->with('success', 'Bus Updated Successfully');
    }

    public function bookingList(Request $request)
    {
        // $packages = DB::table('bookings')
        //     ->join('packages', 'packages.id', '=', 'bookings.package_id')
        //     ->join('buses', 'buses.id', '=', 'packages.bus_id')
        //     ->join('statuses', 'statuses.id', '=', 'bookings.status_id')
        //     ->join('users', 'users.id', '=', 'bookings.user_id')
        //     ->select('bookings.parent_id', 'buses.plate', 'packages.package_name', 'packages.inclusion', 'packages.package_rate', 'bookings.status_id', 'bookings.created_at', 'statuses.name as status_name', 'bookings.id as booking_id', 'bookings.booking_date as booking_date', 'bookings.booking_date_end as booking_date_end', 'bookings.created_at', 'bookings.hasCancelRequest', 'users.first_name as first_name', 'users.last_name as last_name')
        //     ->orderBy('bookings.id', 'DESC')
        //     ->get();

        $bookings = Booking::with(['parent', "user", "package.bus", "status", "addons", "cancelRequest", "payment"]);

        if ($request->has('status')) {
            switch ($request->status) {
                case '4':
                    $bookings = $bookings->where("status_id", Status::CANCELED);
                    break;
                case '3':
                    $bookings = $bookings->where("status_id", Status::COMPLETED);
                    break;
                case '2':
                    $bookings = $bookings->where("status_id", Status::APPROVED);
                    break;
                case '1':
                    $bookings = $bookings->where("status_id", Status::PENDING);
                    break;
                case '0':
                default:
                    break;
            }
        }

        if ($request->has("from_date") && $request->from_date != null && $request->has("to_date") && $request->to_date != null) {
            $from = Carbon::parse($request->from_date);
            $to = Carbon::parse($request->to_date);
            $bookings = $bookings->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
        }

        $bookings = $bookings->latest()->get();

        return view('admin.booking', compact('bookings'));
    }

    public function sales()
    {
        if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
            $from = Carbon::parse($_GET['from_date']);
            $to = Carbon::parse($_GET['to_date']);

            // $packages = DB::table('bookings')
            //     ->join('packages', 'packages.id', '=', 'bookings.package_id')
            //     ->join('users', 'users.id', '=', 'bookings.user_id')
            //     ->join('buses', 'buses.id', '=', 'packages.bus_id')
            //     ->join('statuses', 'statuses.id', '=', 'bookings.status_id')
            //     ->where('bookings.status_id', 4)
            //     ->whereBetween('bookings.created_at', [$from, $to])
            //     ->select('users.first_name', 'users.last_name', 'buses.plate', 'packages.package_name', 'packages.inclusion', 'packages.package_rate', 'bookings.status_id', 'bookings.created_at', 'statuses.name as status_name', 'bookings.id as booking_id', 'bookings.booking_date as booking_date', 'bookings.created_at')
            //     ->get();
            $bookings = Booking::with(['parent', "user", "package.bus", "status", "addons", "cancelRequest", "payment"])
                ->whereBetween('created_at', [$from, $to])
                ->where('status_id', Status::COMPLETED)
                ->latest()
                ->get();
        } else {
            // $packages = DB::table('bookings')
            //     ->join('packages', 'packages.id', '=', 'bookings.package_id')
            //     ->join('users', 'users.id', '=', 'bookings.user_id')
            //     ->join('buses', 'buses.id', '=', 'packages.bus_id')
            //     ->join('statuses', 'statuses.id', '=', 'bookings.status_id')
            //     ->where('bookings.status_id', 4)
            //     ->select('users.first_name', 'users.last_name', 'buses.plate', 'packages.package_name', 'packages.inclusion', 'packages.package_rate', 'bookings.status_id', 'bookings.created_at', 'statuses.name as status_name', 'bookings.id as booking_id', 'bookings.booking_date as booking_date', 'bookings.created_at')
            //     ->get();
            $bookings = Booking::with(['parent', "user", "package.bus", "status", "addons", "cancelRequest", "payment"])
                ->where('status_id', Status::COMPLETED)
                ->latest()
                ->get();
        }




        return view('admin.sales', compact('bookings'));
    }

    public function report()
    {
        $baseBookings = Booking::with(['package'])
            // ->whereYear('created_at', Carbon::now()->year)
            ->where('status_id', 4)
            ->whereNull('parent_id')
            ->get();

        $addonBookings = Booking::with(['package'])
            // ->whereYear('created_at', Carbon::now()->year)
            ->where('status_id', 4)
            ->whereNotNull('parent_id')
            ->get();

        $addonAddons = Booking::with(['addons'])
            // ->whereYear('created_at', Carbon::now()->year)
            ->where('status_id', 4)
            ->get();


        $data = [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
        ];

        $addonData = [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
        ];

        // Get Days In The Current Month
        $dayLabels = [];
        $dayData = [];
        $dayAddons = [];
        $monthPeriod = CarbonPeriod::create(now()->startOfMonth(), now()->endOfMonth());
        foreach ($monthPeriod as $idx => $date) {
            $dayLabels[] = $date->format('d');
            $dayData[$idx] = 0;
            $dayAddons[$idx] = 0;
        }

        // Get Years
        $yearLabels = [];
        $yearData = [];
        $yearAddons = [];
        for ($i = 0; $i < 3; $i++) {
            if ($i == 0) {
                $year = now()->format("Y");
            } else {
                $year = now()->subYears($i)->format("Y");
            }

            $yearLabels[] = $year;
            $yearData[] = 0;
            $yearAddons[] = 0;
        }

        // dd($yearData);
        foreach ($baseBookings as $booking) {
            $month = ltrim($booking->created_at->format('m'), "0");
            $data[$month - 1] += (float) $booking->package->package_rate;

            if (in_array($booking->created_at->format('d'), $dayLabels)) {
                $dayData[(int) $booking->created_at->format('d')] += (float) $booking->package->package_rate;
            }

            if (in_array($booking->created_at->format('Y'), $yearLabels)) {
                $key = array_search($booking->created_at->format('Y'), $yearLabels);
                $yearData[$key] += (float) $booking->package->package_rate;
            }
        }

        foreach ($addonBookings as $booking) {
            $month = ltrim($booking->created_at->format('m'), "0");
            $addonData[$month - 1] += (float) $booking->package->package_rate;

            if (in_array($booking->created_at->format('d'), $dayLabels)) {
                $dayAddons[$booking->created_at->format('d')] += (float) $booking->package->package_rate;
            }

            if (in_array($booking->created_at->format('Y'), $yearLabels)) {
                $key = array_search($booking->created_at->format('Y'), $yearLabels);
                $yearAddons[$key] += (float) $booking->package->package_rate;
            }
        }

        foreach ($addonAddons as $booking) {
            foreach ($booking->addons as $addon) {
                $month = ltrim($booking->created_at->format('m'), "0");
                $addonData[$month - 1] += (float) $addon->price;

                if (in_array($booking->created_at->format('d'), $dayLabels)) {
                    $dayAddons[$booking->created_at->format('d')] += (float) $addon->price;
                }

                if (in_array($booking->created_at->format('Y'), $yearLabels)) {
                    $key = array_search($booking->created_at->format('Y'), $yearLabels);
                    $yearAddons[$key] += (float) $addon->price;
                }
            }
        }

        $labels = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ];

        $yearData = array_reverse($yearData);
        $yearAddons = array_reverse($yearAddons);
        $yearLabels = array_reverse($yearLabels);

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->get();
        
        $data_cust = [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
        ];

        

        // Get Days In The Current Month
        $dayLabels_cust = [];
        $dayData_cust = [];
       
        $monthPeriod_cust = CarbonPeriod::create(now()->startOfMonth(), now()->endOfMonth());
        foreach ($monthPeriod_cust as $idx => $date) {
            $dayLabels_cust[] = $date->format('d');
            $dayData_cust[$idx] = 0;
           
        }

       
        // Get Years
        $yearLabels_cust = [];
        $yearData_cust = [];
       
        for ($i = 0; $i < 3; $i++) {
            if ($i == 0) {
                $year = now()->format("Y");
            } else {
                $year = now()->subYears($i)->format("Y");
            }

            $yearLabels_cust[] = $year;
            $yearData_cust[] = 0;
           
        }

        // dd($yearData);
        foreach ($users as $user) {
            $month = ltrim($booking->created_at->format('m'), "0");
            $data_cust[$month - 1] += 1;

            Log::debug($user->created_at->format('d'));
            if (in_array($user->created_at->format('d'), $dayLabels_cust)) {
                $dayData_cust[(int)$user->created_at->format('d')] ++;
            }
           
            if (in_array($user->created_at->format('Y'), $yearLabels_cust)) {
                $key = array_search($user->created_at->format('Y'), $yearLabels_cust);
                $yearData_cust[$key] += 1;
            }
        }

        // dd($yearData);
        // foreach ($baseBookings as $booking) {
        //     $month = ltrim($booking->created_at->format('m'), "0");
        //     $data[$month - 1] += (float) $booking->package->package_rate;

        //     if (in_array($booking->created_at->format('d'), $dayLabels)) {
        //         $dayData[$booking->created_at->format('d')] += (float) $booking->package->package_rate;
        //     }

        //     if (in_array($booking->created_at->format('Y'), $yearLabels)) {
        //         $key = array_search($booking->created_at->format('Y'), $yearLabels);
        //         $yearData[$key] += (float) $booking->package->package_rate;
        //     }
        // }


        
        $labels_cust = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ];

        $yearData_cust = array_reverse($yearData_cust);
       
        $yearLabels_cust = array_reverse($yearLabels_cust);


        //////
       


        //////

        //monthly
         $bookings_m =Booking::with(["package", "addons"])->whereMonth('created_at',Carbon::now()->month)->get();
         $bookingData_m = [];
         $bookingAddons_m = [];

          foreach ($bookings_m as $booking_m) {
            // Check if already in array
            if (array_key_exists($booking_m->package->id, $bookingData_m)) {
                $bookingData_m[$booking_m->package->id]["count"] += 1;
            } else {
                $bookingData_m[$booking_m->package->id] = [
                    "package_name" => $booking_m->package->package_name,
                    "count" => 1,
                    "top_addon" => null,
                    "top_addon_count" => null,
                ];
            }

            // Get Count Of Most Booked Addon
            foreach ($booking_m->addons as $addon) {
                if (!array_key_exists($addon->booking->package_id, $bookingAddons_m)) {
                    $bookingAddons_m[$addon->booking->package_id] = [];
                }
                array_push($bookingAddons_m[$addon->booking->package_id], $addon->name);
            }
         }

         // Calculate Most Popular Addon
        foreach ($bookingAddons_m as $idx => $addonArray) {
            $nameCount_m = array_count_values($addonArray);
            $topAddon_m = array_keys($nameCount_m, max($nameCount_m));
            $bookingData_m[$idx]["top_addon"] = $topAddon_m[0];
            $bookingData_m[$idx]["top_addon_count"] = max($nameCount_m);
            // dd($idx, $addonArray, $nameCount, $topAddon);
        }
        // Sort By Most Bookings
        usort($bookingData_m, function ($a, $b) {
            return $b["count"] - $a["count"];
        });

        $package_labels_m = [];
        $package_addon_labels_m = [];
        $package_count_labels_m = [];
        $package_addoncount_labels_m = [];
        foreach($bookingData_m as $idx => $package_name){
            $package_labels_m[$idx] = [$package_name['package_name'],$package_name['top_addon'] ?? '' ];
            $package_count_labels_m[$idx] = $package_name['count'];
            $package_addoncount_labels_m[$idx] = $package_name['top_addon_count'];
        }


        //
        //
        //

        //whole year
        $bookings_y =Booking::with(["package", "addons"])->whereYear('created_at',Carbon::now()->year)->get();
        $bookingData_y = [];
        $bookingAddons_y = [];

         foreach ($bookings_y as $booking_y) {
           // Check if already in array
           if (array_key_exists($booking_y->package->id, $bookingData_y)) {
               $bookingData_y[$booking_y->package->id]["count"] += 1;
           } else {
               $bookingData_y[$booking_y->package->id] = [
                   "package_name" => $booking_y->package->package_name,
                   "count" => 1,
                   "top_addon" => null,
                   "top_addon_count" => null,
               ];
           }

           // Get Count Of Most Booked Addon
           foreach ($booking_y->addons as $addon) {
                if (!array_key_exists($addon->booking->package_id, $bookingAddons_y)) {
                    $bookingAddons_y[$addon->booking->package_id] = [];
                }
                array_push($bookingAddons_y[$addon->booking->package_id], $addon->name);
            }
            }

        // Calculate Most Popular Addon
            foreach ($bookingAddons_y as $idx => $addonArray) {
                $nameCount_y = array_count_values($addonArray);
                $topAddon_y = array_keys($nameCount_y, max($nameCount_y));
                $bookingData_y[$idx]["top_addon"] = $topAddon_y[0];
                $bookingData_y[$idx]["top_addon_count"] = max($nameCount_y);
                // dd($idx, $addonArray, $nameCount, $topAddon);
            }
            // Sort By Most Bookings
            usort($bookingData_y, function ($a, $b) {
                return $b["count"] - $a["count"];
            });

            $package_labels_y = [];
            $package_addon_labels_y = [];
            $package_count_labels_y = [];
            $package_addoncount_labels_y = [];
            foreach($bookingData_y as $idx => $package_name){
                $package_labels_y[$idx] = [$package_name['package_name'],$package_name['top_addon'] ?? '' ];
                $package_count_labels_y[$idx] = $package_name['count'];
                $package_addoncount_labels_y[$idx] = $package_name['top_addon_count'];
            }

 
      // dd($bookingData_m[0]['package_name']);
        // foreach ($bookings as $booking) {
        //     // Check if already in array
        //     if (array_key_exists($booking->package->id, $bookingData)) {
        //         $bookingData[$booking->package->id]["count"] += 1;
        //     } else {
        //         $bookingData[$booking->package->id] = [
        //             "package_name" => $booking->package->package_name,
        //             "count" => 1,
        //             "top_addon" => null,
        //             "top_addon_count" => null,
        //         ];
        //     }

        //     // Get Count Of Most Booked Addon
        //     foreach ($booking->addons as $addon) {
        //         if (!array_key_exists($addon->booking->package_id, $bookingAddons)) {
        //             $bookingAddons[$addon->booking->package_id] = [];
        //         }
        //         array_push($bookingAddons[$addon->booking->package_id], $addon->name);
        //     }
        // }

        // // Calculate Most Popular Addon
        // foreach ($bookingAddons as $idx => $addonArray) {
        //     $nameCount = array_count_values($addonArray);
        //     $topAddon = array_keys($nameCount, max($nameCount));
        //     $bookingData[$idx]["top_addon"] = $topAddon[0];
        //     $bookingData[$idx]["top_addon_count"] = max($nameCount);
        //     // dd($idx, $addonArray, $nameCount, $topAddon);
        // }

        // // Sort By Most Bookings
        // usort($bookingData, function ($a, $b) {
        //     return $b["count"] - $a["count"];
        // });
        // dd($yearLabels, $yearData, $yearAddons);
        // dd($dayLabels, $dayData, $dayAddons);

        return view('admin.report', compact('labels', 'data', 'addonData', 'dayData', 'dayLabels', 'dayAddons', 'yearData', 'yearLabels', 'yearAddons','labels_cust', 'data_cust', 'dayData_cust', 'dayLabels_cust', 'yearData_cust', 'yearLabels_cust','package_labels_m','package_count_labels_m','package_addoncount_labels_m','package_labels_y','package_count_labels_y','package_addoncount_labels_y'));
    }

    public function busPackage($id)
    {
        $bus = Bus::find($id);
        $packages = Package::where('bus_id', $id)->get();
        return view('admin.package', compact('packages', 'bus'));
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

        return back()->with('success', 'Bus Package Created Successfully');
    }

    public function customer_booking_packages()
    {
        $packages = DB::table('packages')
            ->join('buses', 'buses.id', '=', 'packages.bus_id')
            ->select('packages.id', 'packages.package_name', 'packages.package_rate', 'packages.inclusion', 'buses.image', 'packages.start_time', 'packages.end_time')
            ->get();
        return view('admin.customer_packages', compact('packages'));
    }

    public function customer_booking_list()
    {
        // $packages = DB::table('bookings')
        //     ->join('packages', 'packages.id', '=', 'bookings.package_id')
        //     ->join('buses', 'buses.id', '=', 'packages.bus_id')
        //     ->join('statuses', 'statuses.id', '=', 'bookings.status_id')
        //     ->where('bookings.user_id', Auth::id())
        //     ->select('bookings.parent_id', 'bookings.booking_date_end as booking_date_end', 'buses.plate', 'packages.package_name', 'packages.inclusion', 'packages.package_rate', 'bookings.status_id', 'bookings.created_at', 'bookings.hasCancelRequest', 'statuses.name as status_name', 'bookings.id as booking_id', 'bookings.booking_date as booking_date', 'bookings.created_at')
        //     ->orderBy('bookings.id', 'desc')
        //     ->get();

        $bookings = Booking::with(['parent', "user", "package.bus", "status", "addons", "cancelRequest", "payment"])
            ->where("user_id", Auth::id())
            ->latest()
            ->get();

        // dd($bookings->toArray());
        return view('admin.customer_booking_list', compact('bookings'));
    }

    public function bookingSetDate(Request $request)
    {
        $validatedData = $request->validate([
            'booking_date'      => ['required'],
            'package_id'      => ['required']

        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['status_id'] = 1;

        $booking = Booking::create($validatedData);

        (new NotifService())->sendNotification(
            $validatedData['user_id'],
            "Booking Created",
            "Your " . $booking->package()->first()->package_name . " booking for " . date("M d, Y", strtotime($validatedData['booking_date'])) . " to " . " has been created."
        );

        return back()->with('success', 'You have Booked Successfully');
    }

    // Depreciated
    public function bookingCancel($id)
    {
        $check = Booking::with(['package'])->where('id', $id)->first();

        if (!$check) {
            abort(404);
        }

        $check->update(['status_id' => 3]);

        (new NotifService())->sendNotification(
            $check->user_id,
            "Booking Cancelled",
            "Your " . $check->package->package_name . " booking for " . date("M d, Y", strtotime($check->booking_date)) . " has been cancelled."
        );

        return back()->with('success', 'Booked Canceled Successfully');
    }
    // Depreciated
    public function bookingCancelRequest($id)
    {
        $check = Booking::with(['package'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$check) {
            abort(404);
        }

        $check->update(['hasCancelRequest' => true]);


        return back()->with('success', 'Booking Cancel Requested');
    }

    public function bookingApprove($id)
    {
        $check = Booking::with(['package'])->where('id', $id)->first();

        if (!$check) {
            abort(404);
        }

        $sameDatePackageBookingStart = Booking::with(['package'])
            ->where("status_id", Status::APPROVED)
            ->where("package_id", $check->package->id)
            ->where("id", "!=", $check->id)
            ->whereBetween("booking_date", [$check->booking_date, $check->booking_date_end])
            ->first();

        if ($sameDatePackageBookingStart != null) {
            return back()->with('error', $sameDatePackageBookingStart->package->package_name . " Package Booking #$sameDatePackageBookingStart->id is already reserved on these dates");
        }

        $sameDatePackageBookingEnd = Booking::with(['package'])
            ->where("status_id", Status::APPROVED)
            ->where("package_id", $check->package->id)
            ->where("id", "!=", $check->id)
            ->whereBetween("booking_date_end", [$check->booking_date, $check->booking_date_end])
            ->first();

        if ($sameDatePackageBookingEnd != null) {
            return back()->with('error', $sameDatePackageBookingEnd->package->package_name . " Package Booking #$sameDatePackageBookingEnd->id is already reserved on these dates");
        }

        $check->update(['status_id' => Status::APPROVED]);

        (new NotifService())->sendNotification(
            $check->user_id,
            "Booking Approved",
            "Your " . $check->package->package_name . " booking for " . date("M d, Y", strtotime($check->booking_date))  . " has been approved."
        );

        return back()->with('success', 'Booked Approved Successfully');
    }

    public function bookingComplete($id)
    {
        $check = Booking::with(['package'])->where('id', $id)->first();

        if (!$check) {
            abort(404);
        }

        $check->update(['status_id' => 4]);

        (new NotifService())->sendNotification(
            $check->user_id,
            "Booking Completed",
            "Your " . $check->package->package_name . " booking for " . date("M d, Y", strtotime($check->booking_date))  . " has been completed."
        );

        return back()->with('success', 'Booked Approved Successfully');
    }

    public function public_packages()
    {
        $randomPackages = Package::inRandomOrder()->limit(10)->get();

        return response()->json([
            "packages" => $randomPackages
        ], 200);
    }
}