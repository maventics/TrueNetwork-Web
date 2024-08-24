<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\emails\EnableUser;
use App\Models\member;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use stdClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{

    protected $res;
    function __construct()
    {
        $this->res = new stdClass;
    }

    function emailLogin(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'email' => "required|email|exists:users,email",
                'password' => 'required',

            ]);
            if (Auth::attempt($data)) {
                //login success
                $user = User::where('id', Auth::id())->where('status', '1')->get()->first();

                if ($user) {
                    $user->token = $user->createToken("API TOKEN")->plainTextToken;
                    $this->res->user = $user;
                    // $this->res->created_at = \Carbon\Carbon::parse($user->created_at)->format('Y-m-d h:i:s A');
                    $this->res->message = 'Account logged in successfully!';
                } else {
                    $this->res->error = "Your account has been blocked by Admin";
                }
                
            } else {
                $this->res->error='Invalid credentials!';
            }
        } catch (Exception $ex) {
            $this->res->error = $ex->getMessage();
        } finally {
            return $this->res;
        }
    }

    // login API with otp


    public function signIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            // Attempt to authenticate the user based on the phone number
            if ($user = User::where('phone', $request->phone)->first()) {
                // Generate a Sanctum token for the authenticated user
                $token = $user->createToken('api_token')->plainTextToken;
                $user->token = $token;
                return response()->json([
                    'status' => 1,
                    'message' => 'Sign-in successful',
                    'user' => $user,
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => 'User not found'
                ], 404);
            }
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 0,
                'message' => $ex->getMessage()
            ], 500);
        }
    }



    // new register code
    public function CheckLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referral_link' => 'required|exists:users,referral_link',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('referral_link', $request->referral_link)->first(); // Fetch the user

        // Store data in the session
        $request->session()->put('referral_link', [
            'referral_link' => $request->referral_link,
            'data' => $user,
        ]);

        return response()->json([
            'message' => 'Referral link validated successfully',
            'data' => $user, // Return the user data in the response
        ], 200);
    }

    public function emailSignUp(Request $request)
    {
        // Proceed with user registration
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required',
            'referral_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            // Generate a unique referral link for the new user
            $newUserReferralLink = Str::random(8);

            // Create a new user
            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'referral_link' => $newUserReferralLink,
                'referral_id' => $request->referral_id,
            ]);

            Mail::to($request->email)->send(new EnableUser($newUser));


            $referral_id_record_store = User::where('referral_link', $request->referral_id)->first();


            // Create a member entry for the new user
            $member = new Member();
            $member->user_id = $newUser->id;
            $member->referral_user_id = $referral_id_record_store ? $referral_id_record_store->id : 0;
            $member->save();



            // Fetch user record
            $userRecord = User::where('email', $request->email)->first();

            $token = $userRecord->createToken("API TOKEN")->plainTextToken;

            // Add token to user record
            $userRecord->token = $token;

            return response()->json([
                'user' => $userRecord,
                'message' => 'User registered successfully',
            ], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }



}

    // Function to generate a unique referral link
    // private function generateReferralLink($length = 2)
    // {
    //     // Define characters that can be used in the referral link
    //     $characters = '0129abeijklmnopq';

    //     // Get the total number of characters
    //     $charactersLength = strlen($characters);

    //     // Initialize the referral link variable
    //     $referralLink = '';

    //     // Generate a random string of the specified length
    //     for ($i = 0; $i < $length; $i++) {
    //         $referralLink .= $characters[rand(0, $charactersLength - 1)];
    //     }

    //     // You can add more uniqueness to the referral link, for example, by adding a timestamp
    //     // $referralLink .= '_' . time(); // Appending current timestamp

    //     return Hash::make($referralLink);
    // }




