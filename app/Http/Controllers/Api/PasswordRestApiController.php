<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\emails\passwordresetotp;
use Exception;
use Illuminate\Http\Request;
use stdClass;
use App\Models\passwordresetrequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class PasswordRestApiController extends Controller
{
    protected $res;

    function __construct()
    {
        $this->res = new stdClass;
    }


    // Password reset otp
    // public function passwordResetOtp(Request $request)
    // {
    //     try {
    //         // Define custom error messages
    //         $customMessages = [
    //             'email.required' => 'The email field is required.',
    //             'email.email' => 'The email must be a valid email address.',
    //         ];

    //         // Validate the incoming request data with custom error messages
    //         $validator = Validator::make($request->all(), [
    //             'email' => 'required|email',
    //         ], $customMessages);

    //         if ($validator->fails()) {
    //             return response()->json(['error' => $validator->errors()->all()], 422);
    //         }

    //         // Generate 6-digit numeric OTP
    //         $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

    //         // Find the user based on the provided email
    //         $user = User::where('email', $request->email)->first();

    //         if (!$user) {
    //             return response()->json(['error' => 'Email not found in user records'], 404);
    //         }


    //         // Update the OTP field in the user's record
    //         $user->otp = $otp;
    //         $user->save();

    //         // Store email in session
    //         $request->session()->put('password_reset_email', $request->email);


    //         // Send the OTP via email
    //         Mail::to($user->email)->send(new PasswordResetOTP($otp));

    //         // Return a success response
    //         return response()->json(['message' => 'OTP sent successfully'], 200);
    //     } catch (Exception $ex) {
    //         // Handle any exceptions
    //         return response()->json(['error' => $ex->getMessage()], 500);
    //     }
    // }

    function email_otp_verified(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'otp'=>'required'
            ]);
            if($validator->fails()){
                $this->res->error=$validator->errors();
                return;
            }
            //authenticate user
            $user=User::where(['email'=>$request->email,'otp'=>$request->otp])->get()->first();
            if($user){
                //auth completed
                $user->token=$user->createToken("API TOKEN")->plainTextToken;
                $this->res->user=$user;
            }else{
                $this->res->error='OTP verification failed!';
            }

        } catch (Exception $ex) {
            $this->res->error = $ex->getMessage();
        } finally {
            return $this->res;
        }
    }

    // create password
    public function create_password(Request $request)
    {
        try {

            // Validate password
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6', // Minimum 6 characters required for password
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            // Set the new password
            $user=User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            // Clear email from session after password reset
            $request->session()->forget('password_reset_email');
            // Destroy the session
            $request->session()->flush();
            return response()->json(['message' => 'Password created successfully']);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    // Password reset otp
public function passwordResetOtp(Request $request)
{
    try {
        // Define custom error messages
        $customMessages = [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
        ];
        // Validate the incoming request data with custom error messages
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], $customMessages);
        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()->all()], 422);
        // }
        // Generate 6-digit numeric OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        // Find the user based on the provided email
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'Email not found in user records'], 404);
        }
        // Update the OTP field in the user's record
        $user->otp = $otp;
        $user->save();
          // Store email in session
        Mail::to($user->email)->send(new PasswordResetOTP($otp));
        // Return a success response
        return response()->json(['message' => 'OTP sent successfully'], 200);
    } catch (Exception $ex) {
        // Handle any exceptions

        return response()->json(['error' => $ex->getMessage()], 500);

    }
}


// public function create_password(Request $request)
// {
//     try {
//         // Retrieve email from session
//         $email = $request->session()->get('password_reset_email');

//         // Find the user based on the stored email
//         $user = User::where('email', $email)->first();
//         if (!$user) {
//             return response()->json(['error' => 'Email not found in user records'], 404);
//         }
//         // Validate password
//         $validator = Validator::make($request->all(), [
//             'password' => 'required|min:6', // Minimum 6 characters required for password
//         ]);
//         if ($validator->fails()) {
//             return response()->json(['error' => $validator->errors()], 400);
//         }
//         // Set the new password
//         $user->password = Hash::make($request->password);
//         $user->save();
//         // Clear email from session after password reset
//         $request->session()->forget('password_reset_email');
//         // Destroy the session
//         $request->session()->flush();
//         return response()->json(['message' => 'Password created successfully']);
//     } catch (\Exception $ex) {
//         return response()->json(['error' => $ex->getMessage()], 500);
//     }
// }



}
