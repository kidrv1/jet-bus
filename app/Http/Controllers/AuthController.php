<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginCheck(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'max:255'],
            'password' => ['required'],
            
        ]);

        if(Auth::attempt($validatedData))
        {

            if( Auth::user()->getRoleNames()[0] == 'admin')
            {
                return redirect()->route('admin_home');
            }else if( Auth::user()->getRoleNames()[0] == 'staff')
            {
                return redirect()->route('admin_bus');
            }else if( Auth::user()->getRoleNames()[0] == 'customer')
            {
               return redirect()->route('customer_booking_packages');
                
            }
        }else 
            {
                return back()->with('error','Invalid Credentials');
            }

    }

    public function register()
    {
        
        return view('auth.register');
    }

    public function registerCheck(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'unique:users', 'max:255'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'position' => ['required'],
            'gender' => ['required'],
            'mobile' => ['required'],
            'password' => ['required','max:20'],
            
        ]);

        $data = $request->all();

        $user = new User;

        if($data['position'] == 1)
        {
            
            $user->first_name       = strtolower($validatedData['first_name']);
            $user->last_name        = strtolower($validatedData['last_name']);
            $user->gender           = strtolower($validatedData['gender']);
            $user->mobile           = strtolower($validatedData['mobile']);
            $user->email            = $validatedData['email'];
            $user->password         = bcrypt($validatedData['password']);
            $user->save();

            $user->assignRole('staff');
            
        }else if($data['position'] == 2)
        {
            $user->first_name       = strtolower($validatedData['first_name']);
            $user->last_name        = strtolower($validatedData['last_name']);
            $user->gender           = strtolower($validatedData['gender']);
            $user->mobile           = strtolower($validatedData['mobile']);
            $user->email            = $validatedData['email'];
            $user->password         = bcrypt($validatedData['password']);
            $user->save();

            $user->assignRole('customer');

        }else {
            return 'Invalid User Type';
        }

        return back()->with('success','Successfully Registered');

        
    }
}
