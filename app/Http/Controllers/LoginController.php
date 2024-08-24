<?php

namespace App\Http\Controllers;

use App\Models\depositrequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Admin;
use App\Models\Withdrawrequest;
use Flasher\Toastr\Laravel\Facade\Toastr;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $withdrawrequests = Withdrawrequest::all();
        return view('login', compact('withdrawrequests'));
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt($request->only(['email', 'password']), $request->get('remember'))) {
            return redirect()->intended('/admin/dashboard');
        }
        Toastr::error("Invalid credentials!");
        return back()->withInput($request->only('email', 'remember'))->withErrors(['email' => 'These credentials do not match our records']);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function profile_update_view()
    {
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        return view('setting.profile_update', compact('withdrawrequests', 'depositRequests'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update_profile(Request $request)
    {

        $this->validate($request, [
            'email'   => 'email',
            'password' => 'min:6'
        ]);

        $email = $request->email;
        $password = $request->password;

        if ($password == "") {
            Admin::where('id', Auth::user()->id)->update(['email' => $email]);
        } else {
            Admin::where('id', Auth::user()->id)->update(['email' => $email, 'password' => Hash::make($password)]);
        }

        return back()->with('message', 'Profile Updated Successfully');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
