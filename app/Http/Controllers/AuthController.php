<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

        if (Auth::attempt($validatedData)) {
            if (Auth::user()->status_id == 1) {
                return back()->with('error', 'Kindly wait for Admin verification!');
            }

            if (Auth::user()->getRoleNames()[0] == 'admin') {
                return redirect()->route('home');
            } elseif (Auth::user()->getRoleNames()[0] == 'staff') {
                return redirect()->route('admin_bus');
            } elseif (Auth::user()->getRoleNames()[0] == 'customer') {
                return redirect()->route('home');
            }
        } else {
            return back()->with('error', 'Invalid Credentials');
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
            'password' => ['required', 'max:20'],
            'valid_id' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vaccine_id' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        $user = new User();

        $file = $validatedData['valid_id'];
        $file2 = $validatedData['vaccine_id'];
        $destinationPath = 'public';

        $extension = $file->getClientOriginalExtension();
        $fileName = rand(111111111, 999999999) . '.' . $extension;
        $save1 = $file->move($destinationPath, $fileName);

        $extension2 = $file2->getClientOriginalExtension();
        $fileName2 = rand(111111111, 999999999) . '.' . $extension2;
        $save2 = $file2->move($destinationPath, $fileName2);

        if ($data['position'] == 1) {
            $user->first_name = strtolower($validatedData['first_name']);
            $user->last_name = strtolower($validatedData['last_name']);
            $user->gender = strtolower($validatedData['gender']);
            $user->mobile = strtolower($validatedData['mobile']);
            $user->email = $validatedData['email'];
            $user->password = bcrypt($validatedData['password']);
            $user->valid_id = $fileName;
            $user->vaccine_id = $fileName2;
            $user->status_id = 1;
            $user->save();

            $user->assignRole('staff');
        } elseif ($data['position'] == 2) {
            $user->first_name = strtolower($validatedData['first_name']);
            $user->last_name = strtolower($validatedData['last_name']);
            $user->gender = strtolower($validatedData['gender']);
            $user->mobile = strtolower($validatedData['mobile']);
            $user->email = $validatedData['email'];
            $user->password = bcrypt($validatedData['password']);
            $user->valid_id = $fileName;
            $user->vaccine_id = $fileName2;
            $user->status_id = 1;
            $user->save();

            $user->assignRole('customer');
        } else {
            return 'Invalid User Type';
        }

        event(new Registered($user));

        return back()->with('success', 'Successfully Registered');
    }

    public function verify(Request $request)
    {
        if ($request->user()->email_verified_at != null) {
            return redirect()->route('home');
        }

        return view('auth.email_verify');
    }

    public function verify_confirm(EmailVerificationRequest $request)
    {
        if ($request->user()->email_verified_at != null) {
            return redirect()->route('home');
        }

        $request->fulfill();
        return redirect()->intended('home');
    }

    public function verify_resend(Request $request)
    {
        if ($request->user()->email_verified_at != null) {
            return redirect()->route('home');
        }

        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent!, Please check your email');
    }
}