<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ManageMemberController;
use App\Mail\emails\deposit;
use App\Models\Comissions;
use App\Models\depositrequest;
use App\Models\Info;
use App\Models\Member;
use App\Models\Reward;
use App\Models\RewardClaimedModel;
use App\Models\Setting;
use App\Models\TransactionTable;
use App\Models\User;
use App\Models\Withdrawrequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Ui\Presets\React;
use Yajra\DataTables\DataTables;

class DepositController extends Controller
{

    // public function updatestatus($id) {
    //     $depositrequest = depositrequest::find($id);
    //     if ($depositrequest) {
    //         if ($depositrequest->status) {
    //             $depositrequest->status = 0;
    //         }else {
    //             $depositrequest->status = 1;
    //         }
    //         $depositrequest->save();
    //     }
    //     return back();
    //  }

    //This function will transact the commission of level 1 and return the user_id
    function transactCommissionToLevel1($depositModel)
    {
        $userId = $depositModel->user_id; //the one who made deposit
        ///find upliner of this user with [$userId]
        //check who invited userId. Thats level 1
        $level1Member = Member::where('user_id', $userId)->get()->first();
        if (!$level1Member) {
            return null;
        }
        $investmentAmount = floatval($depositModel->depositamount);
        $percentage = Setting::where('key', 'level_1_commission_percentage')->get()->first()->value;
        $commission = is_numeric($investmentAmount) && is_numeric($percentage) ? ($investmentAmount * ($percentage / 100)) : 0;
        //Credit the commission to upliner
        $tr = TransactionTable::create([
            'user_id' => $level1Member->referral_user_id,
            'type' => "Commision",
            'avaiable_amount' => $commission,
            'status' => 1,
            'deposit_id' => $depositModel->id,
        ]);
        $user = User::find($level1Member->referral_user_id); //upliner user
        Comissions::create([
            'user_id' => $level1Member->referral_user_id,
            'member_id' => $userId,
            'amount' => $commission,
            'commission' => $percentage,
            'level' => 'Level 1',
            'transaction_id' => $tr->id,
        ]);
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser(
            $user->device_token,
            'Your commission received on deposit!',
            'PKR' . $commission . ' has been credited into your wallet!',
            null
        );

        return $level1Member->referral_user_id;
    }

    function transactCommissionToLevel2($depositModel, $level1UserId)
    {
        $userId = $depositModel->user_id; //the one who made a deposit
        ///find upliner of level1UserId for which $userId will be on level 2
        $level2Member = Member::where('user_id', $level1UserId)->get()->first();
        if (!$level2Member) {
            return null;
        }
        $investmentAmount = floatval($depositModel->depositamount);
        $percentage = Setting::where('key', 'level_2_commission_percentage')->get()->first()->value;
        $commission = is_numeric($investmentAmount) && is_numeric($percentage) ? ($investmentAmount * ($percentage / 100)) : 0;
        //Credit the commission to upliner
        $tr = TransactionTable::create([
            'user_id' => $level2Member->referral_user_id,
            'type' => "Commision",
            'avaiable_amount' => $commission,
            'status' => 1,
            'deposit_id' => $depositModel->id,
        ]);
        $user = User::find($level2Member->referral_user_id); //upliner of level 1
        Comissions::create([
            'user_id' => $level2Member->referral_user_id,
            'member_id' => $userId,
            'amount' => $commission,
            'commission' => $percentage,
            'level' => 'Level 2',
            'transaction_id' => $tr->id,
        ]);
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser(
            $user->device_token,
            'Your commission received on deposit!',
            'PKR' . $commission . ' has been credited into your wallet!',
            null
        );
        return $level2Member;
    }
    function transactCommissionToLevel3($depositModel, $level2UserId)
    {

        $userId = $depositModel->user_id;
        ///find upliner of level1UserId for which $userId will be on level 2
        //If requirements changes that there  can be multiple level 2s then use foreach here...

        // Info::create([
        //     'message'=>'levl 2 id'.$level2UserId->id,
        // ]);
        $upliner = Member::where('user_id', $level2UserId->referral_user_id)->get()->first();
        if (!$upliner) {
            return;
        }
        $level3Member = User::findOrFail($upliner->referral_user_id);

        if (!$level3Member) {
            return null;
        }

        $investmentAmount = floatval($depositModel->depositamount);
        $percentage = Setting::where('key', 'level_3_commission_percentage')->get()->first()->value;

        $commission = is_numeric($investmentAmount) && is_numeric($percentage) ? ($investmentAmount * ($percentage / 100)) : 0;
        //Credit the commission to upliner

        $tr = TransactionTable::create([
            'user_id' => $level3Member->id,
            'type' => "Commision",
            'avaiable_amount' => $commission,
            'status' => 1,
            'deposit_id' => $depositModel->id,

        ]);

        Comissions::create([
            'user_id' => $level3Member->id,
            'member_id' => $userId,
            'amount' => $commission,
            'commission' => $percentage,
            'level' => 'Level 3',
            'transaction_id' => $tr->id,
        ]);
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser(
            $level3Member->device_token,
            'Your commission received on deposit!',
            'PKR' . $commission . ' has been credited into your wallet!',
            null
        );
        return $level3Member;
    }

    ///Distribute deposit commission to team..
    function distributeDepositCommisionToTeam($depositModel)
    {
        $level1UserId = $this->transactCommissionToLevel1($depositModel);
        if ($level1UserId) {
            $level2UserId = $this->transactCommissionToLevel2($depositModel, $level1UserId);
            if ($level2UserId) {
                $level3UserId = $this->transactCommissionToLevel3($depositModel, $level2UserId);
            }
        }
    }

    ///Check if its first deposit of user then pay 5% bonus to user.
    function checkForFirstDepositBonus($depoitModel)
    {
        $txs = TransactionTable::where([
            'user_id' => $depoitModel->user_id,

        ])->get();
        //if its first transaction then pay user bonus.
        if (sizeof($txs) < 2) {
            //add bonus transaction. with notification.

            //Send push notificaiton
            $user = User::find($depoitModel->user_id);

            $investmentAmount = floatval($depoitModel->depositamount);
            $percentage = Setting::where('key', 'deposit_bonus_percentage')->get()->first()->value;
            $bonus = is_numeric($investmentAmount) && is_numeric($percentage) ? ($investmentAmount * ($percentage / 100)) : 0;
            TransactionTable::create([
                'user_id' => $depoitModel->user_id,
                'type' => "Bonus",
                'avaiable_amount' => $bonus,
                'status' => 1,
                'deposit_id' => $depoitModel->id,
            ]);
            $notification = new NotificationController();
            $notification->sendNotificationToSingleUser(
                $user->device_token,
                'Congratulations you made your first deposit!',
                'PKR' . $bonus . ' has been credited into your wallet!',
                null
            );
        }
    }

    function updatestatusforrejected(Request $request, $id)
    {
        DepositRequest::where('id', $id)->update(['status' => 2]);
        $depo = DepositRequest::find($id);
        $user = User::find($depo->user_id);
        //rejected
        //Send push notificaiton
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser($user->device_token, 'Your deposit request has been rejected!', 'PKR' . $depo->depositamount . ' can not be credited into your wallet! Contact support team.', null);
        return back()->with(['message' => 'Deposit request rejected!']);
    }


    function changeStatusOfDeposit(Request $request, $id)
    {
        // return depositrequest::where('id',$id)->get();
        // return $request->status;
        DepositRequest::where('id', $id)->update([
            // 'status' => $request->status, // Here status is not coming
            'status' => 1,
        ]);
        $depo = DepositRequest::find($id);
        $user = User::find($depo->user_id);
        if ($depo) {
            if ($depo->status == 2) {

                //rejected
                //Send push notificaiton
                $notification = new NotificationController();
                $notification->sendNotificationToSingleUser($user->device_token, 'Your deposit request has been rejected!', 'PKR' . $depo->depositamount . ' can not be credited into your wallet! Contact support team.', null);
                return back()->with(['message' => 'Deposit request rejected!']);
            }
        }



        $message = "";


        TransactionTable::create([
            'user_id' => $user->id,
            'type' => 'Deposit',
            'status' => 1,
            'avaiable_amount' => $depo->depositamount,
            'deposit_id' => $depo->id,
        ]);
        //Send push notificaiton
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser($user->device_token, 'Your deposit request has been approved!', 'PKR' . $depo->depositamount . ' has been credited into your wallet!', null);
        //Send email
        // Mail::to($user->email)->send(new deposit($user, $depo));
        if ($request->status == 1) {
            $message = "You have changed the status of the user. Now the user is enabled.";
        } elseif ($request->status == 2) {
            $message = "You have changed the status of the user. Now the user is disabled.";
        }

        $this->checkForFirstDepositBonus($depo); //responsible to add bonus for user.
        $this->distributeDepositCommisionToTeam($depo); //responsibile to add commission to team.
        //check total team deposit rewards
        $this->checkDepositGoalReward($depo);
        return back()->with(['message' => $message]);
    }

    ///Distribute the rewards if goal achieved 
    function checkDepositGoalReward($depo)
    {

        //if total team deposit reaches 100000 then reward the level 1 member of current user.
        //get level 1 member of current user...
        $upliner = $this->getLevel1MemberOfLevel3User($depo->user_id);

        if ($upliner) {
            // Info::create(['message' => 'upliner agya ' . $upliner->user_id]);
            //check if already has been rewarded or not
            // if (RewardClaimedModel::where([
            //     'reward_id' => 1,
            //     'user_id' => $upliner->referral_user_id,

            // ])->exists()) {
            //     //alread given..
            //     Info::create(['message' => "reward is Already given"]);
            //     return;
            // }


            // now get all deposit type transactions to determine total deposit amount...
            $manageMembers = new ManageMemberController();
            $totalDeposits = 0;
            $level1Members = $manageMembers->getLevel1Members($upliner->user_id);
 
            $level2 = $manageMembers->getLevel2Members($level1Members); 

            $level3 = $manageMembers->getLevel3Members($level2);


            //Summing all deposits
            $totalDeposits += $this->sumAllDepositTransactions($level1Members);
            $totalDeposits += $this->sumAllDepositTransactions($level2);
            $totalDeposits += $this->sumAllDepositTransactions($level3);

            // Get the total rewards already dispatched to the upliner
            // $totalRewardsDispatched = RewardClaimedModel::where('user_id', $upliner->user_id)
            //     ->count(); // Count how many rewards have been dispatched to leader

            // Fetch the latest reward record for the user
            $latestReward = RewardClaimedModel::where('user_id', $upliner->user_id)
                ->orderBy('id', 'desc')
                ->first();

            // Check if a record was found
            if ($latestReward) {
                $lastDeposit = $latestReward->last_deposit;
            } else {
                $lastDeposit = 0; // Default value if no records are found
            }

            // Calculate the reward
            $Reward = $totalDeposits - $lastDeposit;

            if ($Reward >= 100000) {
                //send reward.
                TransactionTable::create([
                    'user_id' => $upliner->user_id, // yahan par upliner ke user_id jaye ge 
                    'type' => "Reward",
                    'avaiable_amount' => 2000,  // yahan pa ma $reward->amount ke jaga by default 200 raka raha hon
                    'deposit_id' => 0,
                    'withdraw_id' => 0,
                    'investment_id' => 0,
                    'status' => 1
                ]);
                RewardClaimedModel::create(['last_deposit' => $totalDeposits, 'user_id' => $upliner->user_id, 'reward_id' => 1, 'status' => 1]);// Add record.
                ///notifiy the user
                $notification = new NotificationController();
                $user = User::find($upliner->user_id);
                // $notification->sendNotificationToSingleUser($user->device_token,'Congratulations You Got PKR'.$RewardDetails->amount,'Your team has achieved 1Lac deposits!',null); //yahan par $reward->amount leka tha laken ma ne bydefault 200 leka ha 
                $notification->sendNotificationToSingleUser($user->device_token, 'Congratulations You Got PKR 2000', 'Your team has achieved 1Lac deposits!', null); //yahan par $reward->amount leka tha laken ma ne bydefault 200 leka ha 
            }
        }
    }


    ///Determines the level 1 user fo level 3 and returns [Member] if found else null.
    function getLevel1MemberOfLevel3User($user_id)
    {
        ///find upliner of current user..

        $upliner = null;
        // $level2User = Member::where(['user_id' => $user_id])->first(); // jan bhai
        $upliner = Member::where(['user_id' => $user_id])->first();
        if ($upliner) {
            //found
            // Info::create(['message' => 'level2User' . $upliner->referral_user_id]);
            //now check if there is an upliner above this one
            $level2 = Member::where(['user_id' => $upliner->referral_user_id])->first();
            if ($level2) {
                $upliner = $level2; // team owner if no upliner found next.
                $level1 = Member::where(['user_id' => $upliner->referral_user_id])->first();
                if ($level1) {
                    $upliner = $level1; // team owner if no upliner found next.
                    $owner = Member::where(['user_id' => $upliner->referral_user_id])->first();
                    if ($owner) {
                        $upliner = $owner; //final user no need to check next upliner.
                    }
                }
            }
        }


        // if ($level2User) {
        //found. Now find upliner of level 2 
        // $upliner = Member::where(['user_id' => $level2User->referral_user_id])->first(); // yahan par var ka name $level1User tha 
        // Info::create(['message'=>'level1User'.$upliner]);


        //now find upliner of level 1 and distribute the reward
        // $upliner = Member::where(['user_id' => $level1User->referral_user_id])->first();
        // Info::create(['message'=>'upliner member'.$upliner]);
        // }

        return $upliner;
    }

    function sumAllDepositTransactions($listOfMembers)
    {
        $totalDeposits = 0;
        foreach ($listOfMembers as $member) {
            //Get transactions of member
            $sumOfDepo = TransactionTable::where('user_id', $member->user_id)
                ->where('type', "Deposit")
                ->sum('avaiable_amount');
            $totalDeposits += $sumOfDepo;
        }

        return $totalDeposits;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = depositrequest::query();
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
                    } else {
                        return "<span class='badge bg-warning'>Pending</span>";
                    }
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->format("d-M-y H:m a");
                })
                ->rawColumns(['user', 'status', 'updated_at'])
                ->make(true);
        }

        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        return view('request.depositrequest', compact('withdrawrequests', 'depositRequests'));
    }


    public function view($id)
    {
        // Fetch the user record based on the provided ID
        $depositrequest = depositrequest::findOrFail($id);

        $withdrawrequests = Withdrawrequest::all();

        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        // Pass the user record to the view
        return view('request.viewdeposit', compact('depositrequest', 'withdrawrequests', 'withdrawrequests', 'depositRequests'));
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
