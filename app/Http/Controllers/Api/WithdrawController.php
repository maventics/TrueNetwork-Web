<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Withdrawrequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use App\Models\member;
use App\Models\TransactionTable;
use App\Models\depositrequest;
use Exception;
use App\Mail\emails\withdraw;
use App\Models\Admin;
use App\Models\Bank\AdminBankDetail;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Withdrawrequest::where('user_id', Auth::id())
            ->with('bank')
            ->latest()
            ->paginate(10);

        return response()->json($data);
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
            $Auth_id = Auth::id();
            $validator = Validator::make($request->all(), [
                'bank_id' => 'required',
                'accountholder' => 'required',
                'accountnumber' => 'required',
                'withdrawamount' => 'required',
                'description' => '',
                // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image upload
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            // Check if any withdraw is made today by the user
            $withdrawnToday = Withdrawrequest::where('user_id', $Auth_id)
                ->whereDate('created_at', Carbon::today())
                ->exists();
            if ($withdrawnToday) {
                $user=User::find(Auth::id());
                $notification = new NotificationController();
                $notification->sendNotificationToSingleUser(
                    $user->device_token,
                    'Your withdraw request rejected!',
                    'You can withdraw only for once in a day!. Try tomorrow.',
                    null
                );
                return response()->json(['error' => "Your limit to widthdaw is exceed try tomorrow!"]);
            }
            // // Fetch data from AuthId
            // $transactionUser = TransactionTable::where('user_id', $Auth_id)->first();
            // if (!$transactionUser) {
            //     return response()->json(['error' => 'No transaction record found for this user.'], 404);
            // }

            // Calculate available amount after withdrawal
            $totalCurrentWithdrawAmount = $request->withdrawamount;
            // Check if the withdrawal amount is less than or equal to the available balance
            $depositSum = TransactionTable::where('user_id', $Auth_id)->where('status', 1)->sum('avaiable_amount');
            if ($depositSum < $totalCurrentWithdrawAmount) {
                return response()->json(['error' => 'User doesn\'t have sufficient balance to withdraw'], 422);
            }
            $percentage = Setting::where('key', 'withdraw_fee_percentage')->get()->first()->value;

            $amount = floatval($request->withdrawamount);

            $fee = is_numeric($amount) && is_numeric($percentage) ? ($amount * ($percentage / 100)) : 0;
            //Subtract fees from total amount of withdraw.
            $remainingAmount = $amount - $fee;


            // Create the withdrawal request
            $withdrawRequest = WithdrawRequest::create([
                'user_id' => $Auth_id,
                'bank_id' => $request->bank_id,
                'accountholder' => $request->accountholder,
                'accountnumber' => $request->accountnumber,
                'withdrawamount' => $remainingAmount,
            ]);


            TransactionTable::create([
                'user_id' => $withdrawRequest->user_id, // Use the user ID associated with the withdrawal
                'type' => 'withdraw',
                'status' => 1,
                // 'avaiable_amount' => $withdraw->withdrawamount * -1, // previous code
                'avaiable_amount' => $remainingAmount * -1,
                'withdraw_id' => $withdrawRequest->id,
            ]);
            TransactionTable::create([
                'user_id' => $withdrawRequest->user_id, // Use the user ID associated with the withdrawal
                'type' => 'Platform Fee',
                'status' => 1,
                // 'avaiable_amount' => $withdraw->withdrawamount * -1, // previous code
                'avaiable_amount' => $fee * -1,
                'withdraw_id' => $withdrawRequest->id,
            ]);

            // Send notification to the user via email (assuming you have implemented this)
            $user = Auth::user();
            Mail::to($user->email)->send(new withdraw($user, $withdrawRequest));

            return response()->json([
                'message' => 'Withdraw added successfully',
                'data' => $withdrawRequest,
            ], 201);
        } catch (Exception $e) {
            // Handle any exceptions here
            return response()->json(['error' => $e->getMessage()], 500);
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
