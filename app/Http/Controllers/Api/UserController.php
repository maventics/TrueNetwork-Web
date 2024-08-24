<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Bank\AdminBank;
use App\Mail\emails\tradeExpire;
use App\Models\Admin;
use App\Models\Bank;
use App\Models\Bank\AdminBankDetail;
use App\Models\bank\User_Bank_Details as BankUser_Bank_Details;
use App\Models\depositrequest;
use App\Models\FakeData;
use App\Models\Investment;
use App\Models\schemes;
use App\Models\TransactionTable;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use App\Models\Withdrawrequest;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\NotificationController;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    protected $res;
     public function get_setting()
    {
        try {
            $setting = Setting::all();
            $this->res = $setting;
        } catch (Exception $ex) {
            $this->res = $ex->getMessage();
        } finally{
           return $this->res;
        }
    }


    public function get_latest_android_version()
    {
        try {
            $android_app_version = Setting::where('key', 'android_app_version')->get()->first();
            $this->res = $android_app_version;
        } catch (Exception $ex) {
            $this->res = $ex->getMessage();
        } finally {
            return $this->res;
        }
    }

    public function user_available_amount()
    {
        $userId = Auth::id(); // Fetch the authenticated user's ID
        try {

            $data = TransactionTable::where('user_id', $userId)->where('status', 1)->sum('avaiable_amount');

            $data = TransactionTable::where('user_id', $userId)->where('type', 'Deposit')->sum('avaiable_amount');
            $data = TransactionTable::where('user_id', $userId)->sum('avaiable_amount');

            
            $this->res = [
                'User_Avaiable_Amount' => $data,
            ];
        } catch (Exception $ex) {
            $this->res = $ex->getMessage();
        } finally {
            return $this->res;
        }
    }
    public function transaction_history()
    {
        $userId = Auth::id(); // Fetch the authenticated user's ID
        try {
            return TransactionTable::where('user_id', $userId)
                ->with(['deposit', 'withdraw', 'investment','deposit.bank','withdraw.bank'])->latest()->get();
        } catch (Exception $ex) {
            // Handle exceptions
            return $ex->getMessage();
        }
    }


    public function active_trade()
    {
        $userId = Auth::id(); // Fetch the authenticated user's ID
        try {
            // Fetch active and expired investments for the user
            $investment = Investment::where('user_id', $userId)
                ->where(function ($query) {
                    $query->where('status', 1) // Active trades
                        ->orWhere('status', 0); // Expired trades
                })
                ->with(['scheme'])
                ->get();

            // Prepare the response
            $data = [
                'trades' => $investment,
            ];


            $this->res = $data;
        } catch (Exception $ex) {
            $this->res = $ex->getMessage();
        } finally {
            return $this->res;
        }
        $AuthId = Auth::id();
        $user = User::find('id', $AuthId);
        //Send push notificaiton
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser($user->device_token, 'Your trade request has been completed!', 'Now , you can claimed the profit from the app!', null);
        //Send email
        Mail::to($user->email)->send(new tradeExpire($user, $investment));
    }




    public function get_user()
    {
        try {
            $data = User::all();
            $this->res = $data;
        } catch (Exception $ex) {
            $this->res = $ex->getMessage();
        } finally {
            return $this->res;
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function upload_profile_image(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as needed
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $user = Auth::user(); // Retrieve the authenticated user

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('/upload_image');

                // Sanitize file name to prevent security vulnerabilities
                $safeImageName = preg_replace('/\s+/', '_', $imageName); // Replace spaces with underscores
                $image->move($path, $safeImageName);

                $imageUrl = '/upload_image/' . $safeImageName; // Image path relative to public directory

                // Update user record in the database with the image path
                $user->image = $imageUrl;
                $user->save();

                return response()->json(['message' => 'Image uploaded successfully!', 'imageUrl' => $imageUrl], 200);
            } else {
                return response()->json(['error' => 'No image file found in the request.'], 400);
            }
        } catch (Exception $ex) {
            // Log the exception for debugging purposes
            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update_user(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',

                'email' => 'email|unique:users,email,' . $id,
                'phone' => 'required',
                'image' => 'image  ', // Validate image file


            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 0, 'errors' => $validator->errors()], 400);
            }

            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;

            $user->phone = $request->phone;

            $user->phone = $request->phone; // Update phone instead of password


            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('upload_image'), $imageName);
                $user->image = $imageName;
            }

            $updated = $user->save();

            if ($updated) {
                return response()->json(['status' => 1, 'message' => 'User updated successfully']);
            } else {
                return response()->json(['status' => 0, 'message' => 'Failed to update user'], 500);
            }
        } catch (Exception $ex) {
            return response()->json(['status' => 0, 'message' => $ex->getMessage()], 500);
        }
    }


    //  update FCM token
    public function updateDeviceToken(Request $request)
    {
        try {
            $user = User::find(Auth::id());

            if (!$user) {
                return response()->json(['error' => 'User not authenticated.'], 401);
            }

            $validator = Validator::make($request->all(), [
                'token' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }

            $user->device_token = $request->token;
            $user->save();

            return response()->json(['message' => 'Token successfully Updated.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
