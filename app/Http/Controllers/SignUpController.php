<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Flasher\Toastr\Laravel\Facade\Toastr;

class SignUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function signUp(Request $request)
    {
        $referral_id = $request->query('id');

        // Fetch the user based on the referral ID
        $user = User::where('referral_link', $referral_id)->first();

        // Check if the user exists
        if (!$user) {
            return 'User not found';
        } else {
            // Pass the user's ID to the view
            return view('signup.index', ['id' => $user->referral_link, 'name' => $user->name]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {


        try {
            // Proceed with user registration
            $validator = $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'required',
                'referral_id' => 'required',
            ]);

            // Generate a unique referral link for the new user
            $newUserReferralLink = uniqid();

            // Create a new user
            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'referral_link' => $newUserReferralLink,
                'referral_id' => $request->referral_id,
            ]);

            //Mail::to($request->email)->send(new EnableUser($newUser));


            $referral_id_record_store = User::where('referral_link', $request->referral_id)->first();


            // Create a member entry for the new user
            $member = new Member();
            $member->user_id = $newUser->id;
            $member->referral_user_id = $referral_id_record_store ? $referral_id_record_store->id : 0;
            $member->save();


            return view('signup.confirm');
        } catch (Exception $ex) {
            Toastr::error($ex->getMessage());
            return back()->withError(['error'=>$ex->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
