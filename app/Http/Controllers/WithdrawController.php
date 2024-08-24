<?php

namespace App\Http\Controllers;

use App\Mail\emails\withdraw;
use Illuminate\Http\Request;
use App\Models\Withdrawrequest;
use App\Models\depositrequest;
use App\Models\Member;
use App\Models\Sale;
use App\Models\Setting;
use App\Models\User;
use App\Models\TransactionTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function updatestatus($id) {
        $Withdrawrequest = Withdrawrequest::find($id);
        if ($Withdrawrequest) {
            if ($Withdrawrequest->status) {
                $Withdrawrequest->status = 0;
            }else {
                $Withdrawrequest->status = 1;
            }
            $Withdrawrequest->save();
        }
        return back();
     }

     public function updatestatusforrejected($id) {
        $Withdrawrequest = Withdrawrequest::find($id);
        if ($Withdrawrequest) {
            if ($Withdrawrequest->status) {
                $Withdrawrequest->status = 0;
            }else {
                $Withdrawrequest->status = 2;
                
                $user = User::findOrFail($Withdrawrequest->user_id);

                $notification = new NotificationController();
                $notification->sendNotificationToSingleUser(
                    $user->device_token,
                    'The withdrawal request has been rejected!',
                    'from the admin!',
                    null
                );
            }
            $Withdrawrequest->save();
            TransactionTable::where('withdraw_id',$id)->delete();
        }
        return back();
     }

     


    //This function will transact the commission of level 1 and return the user_id
    function transactCommissionToLevel1($withdrawModel, $remainingAmount)
    {
        $userId = $withdrawModel->user_id;
        ///find upliner of this user with [$userId]
        //check who invited userId. Thats level 1
        $level1Member = Member::where('user_id', $userId)->get()->first();
        if (!$level1Member) {
            return null;
        }
        $percentage = Setting::where('key', 'level_1_commission_percentage')->get()->first()->value;
        $commission = is_numeric($remainingAmount) && is_numeric($percentage) ? ($remainingAmount * ($percentage / 100)) : 0;
        //Credit the commission to upliner
        TransactionTable::create([
            'user_id' => $level1Member->referral_user_id,
            'type' => "Commision",
            'avaiable_amount' => $commission,
            'status' => 1,
            'withdraw_id'=>$withdrawModel->id,
        ]);
        $user = User::find($level1Member->referral_user_id);
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser(
            $user->device_token,
            'Your commission received on withdrawal!',
            'PKR' . $commission . ' has been credited into your wallet!',
            null
        );

        return $level1Member->referral_user_id;
    }

    function transactCommissionToLevel2($withdraw, $level1UserId, $remainingAmount)
    {
        $userId = $withdraw->user_id;
        ///find upliner of level1UserId for which $userId will be on level 2
        $level2Member = Member::where('user_id', $level1UserId)->get()->first();
        if (!$level2Member) {
            return null;
        }
        $percentage = Setting::where('key', 'level_2_commission_percentage')->get()->first()->value;
        $commission = is_numeric($remainingAmount) && is_numeric($percentage) ? ($remainingAmount * ($percentage / 100)) : 0;
        //Credit the commission to upliner
        TransactionTable::create([
            'user_id' => $level2Member->referral_user_id,
            'type' => "Commision",
            'avaiable_amount' => $commission,
            'status' => 1,
            'withdraw_id'=>$withdraw->id,
        ]);
        $user = User::find($level2Member->referral_user_id);
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser(
            $user->device_token,
            'Your commission received on withdrawal!',
            'PKR' . $commission . ' has been credited into your wallet!',
            null
        );
        return $level2Member;
    }
    function transactCommissionToLevel3($withdraw, $level2UserId, $remainingAmount)
    {
        $userId = $withdraw->user_id;
        ///find upliner of level1UserId for which $userId will be on level 2
        //If requirements changes that there  can be multiple level 2s then use foreach here...
        $level3Member = Member::where('user_id', $level2UserId)->get()->first();
        if (!$level3Member) {
            return null;
        }
        $percentage = Setting::where('key', 'level_3_commission_percentage')->get()->first()->value;
        $commission = is_numeric($remainingAmount) && is_numeric($percentage) ? ($remainingAmount * ($percentage / 100)) : 0;
        //Credit the commission to upliner
        TransactionTable::create([
            'user_id' => $level3Member->referral_user_id,
            'type' => "Commision",
            'avaiable_amount' => $commission,
            'status' => 1,
            'withdraw_id'=>$withdraw->id,
        ]);
        $user = User::find($level3Member->referral_user_id);
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser(
            $user->device_token,
            'Your commission received!',
            'PKR' . $commission . ' has been credited into your wallet!',
            null
        );
        return $level3Member;
    }

    ///Distribute deposit commission to team..
    function distributeDepositCommisionToTeam($withdraw, $remainingAmount)
    {
        $level1UserId = $this->transactCommissionToLevel1($withdraw, $remainingAmount);
        if ($level1UserId) {
            $level2UserId = $this->transactCommissionToLevel2($withdraw, $level1UserId, $remainingAmount);
            if ($level2UserId) {
                $level3UserId = $this->transactCommissionToLevel2($withdraw, $level2UserId, $remainingAmount);
            }
        }
    }

    //charge platform fee and return remaining amount for commissions.
    function chargePlatformFee($withdraw)
    {
        //charge the withdraw with platform fee.
        $percentage = Setting::where('key', 'withdraw_fee_percentage')->get()->first()->value;

        //Send push notificaiton
        $user = User::find($withdraw->user_id);

        $amount = floatval($withdraw->withdrawamount );

        $fee = is_numeric($amount) && is_numeric($percentage) ? ($amount * ($percentage / 100)) : 0;
        //Subtract fees from total amount of withdraw.
        $remainingAmount = $amount - $fee;

        //charge user with platform fee.
        TransactionTable::create([
            'user_id' => $withdraw->user_id,
            'type' => "Platform Fee " . $percentage . '%',
            'avaiable_amount' => $fee * -1, //subtraction in negative
            'status' => 1,
            'withdraw_id'=>$withdraw->id,
        ]);
        //add fee to profits.
        Sale::create([
            'user_id' => $withdraw->user_id,
            'profit' => $fee
        ]);
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser(
            $user->device_token,
            'Congratulations your withdraw request has been approved!',
            'PKR' . $remainingAmount . ' has been sent to your bank account',
            null
        );

        return $remainingAmount;
    }
    public function changeStatusOfWithdraw(Request $request, $id)
    {
        // Find the withdrawal request by its ID
        $withdraw = Withdrawrequest::find($id);

        // Check if the withdrawal request exists
        if (!$withdraw) {
            // Handle scenario where withdrawal request is not found
            return back()->with(['error' => 'Withdrawal request not found.']);
        }
        
        // Toggle the status of the withdrawal request
        $withdraw->status = !$withdraw->status;

        // Save the updated status
        $withdraw->save();

        // Get the user associated with the withdrawal request
        $user = User::find($withdraw->user_id);

        // Check if the user exists
        if (!$user) {
            // Handle scenario where user is not found
            return back()->with(['error' => 'User not found.']);
        }
        // Send push notification to the user
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser($user->deviceToken, 'Your Withdraw request has been ' . ($withdraw->status ? 'approved!' : 'rejected!'), 'PKR' . $withdraw->withdrawamount . ' has been ' . ($withdraw->status ? 'credited into your wallet!' : 'not credited into your wallet!'), null);
        if ($withdraw->status == 0) {
            TransactionTable::where('withdraw_id',$withdraw->id)->delete();
            return redirect('/admin/dashboard');
        }

        // Send email notification to the user
        Mail::to($user->email)->send(new withdraw($user, $withdraw));

        // Set the message based on the status change
        $message = $withdraw->status ? "The withdrawal request has been approved." : "The withdrawal request has been rejected.";
        // if ($withdraw->status == 1) {
        //     //charge platform fee
          
        //     //distribute commissions.
        //    // $this->distributeDepositCommisionToTeam($withdraw, $remainingAmount);
        // }
        // Redirect back with a success message
        return back()->with(['message' => $message]);
    }



    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Withdrawrequest::query();
            return DataTables::of($data)
                ->addColumn('user', function ($row) {
                    $user = User::find($row->user_id);
                    return "<a href='/admin/user/view/" . $row->user_id . "'>" . $user->name . "</a>";
                })
                ->order(function ($query) {
                    $query->orderBy('updated_at', 'DESC'); // Replace with your custom column
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return "<span class='badge bg-primary'>Approved</span>";
                    } else if ($row->status == 2) {
                        return "<span class='badge bg-danger'>Rejected</span>";
                    }else{
                        return "<span class='badge bg-warning'>Pending</span>";
                    }
                })
                ->editColumn('updated_at',function($row){
                    return $row->updated_at->format("d-M-y H:m a");
                })
                ->editColumn('bank_id',function($row){
                    return $row->bank->bank;
                })
                ->rawColumns(['user', 'status','updated_at'])
                ->make(true);
        }

        $depositrequests = depositrequest::all();
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        return view('request.withdrawrequest', compact('depositrequests', 'withdrawrequests', 'depositRequests'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function view($id)
    {
        // Fetch the user record based on the provided ID
        $depositrequest = depositrequest::all();

        $withdrawrequests = Withdrawrequest::findOrFail($id);

        //   $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        // Pass the user record to the view
        return view('request.viewwithdraw', compact('depositrequest', 'withdrawrequests', 'withdrawrequests', 'depositRequests'));
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
