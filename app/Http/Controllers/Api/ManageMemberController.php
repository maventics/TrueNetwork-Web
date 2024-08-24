<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comissions;
use App\Models\depositrequest;
use App\Models\Member;
use App\Models\Setting;
use App\Models\TransactionTable;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use stdClass;

class ManageMemberController extends Controller
{

    function commissiontest()
    {
        $test = Comissions::where('user_id',32)->sum('amount');
        return $test;
    }

    function getCommissions()
    {
        $res = new stdClass;
        $res->level_1 = Comissions::where('user_id', Auth::id())->where('level', 'Level 1')->sum('amount');
        $res->level_2 = Comissions::where('user_id', Auth::id())->where('level', 'Level 2')->sum('amount');
        $res->level_3 = Comissions::where('user_id', Auth::id())->where('level', 'Level 3')->sum('amount');
        $member = Member::where('user_id', Auth::id())->orderBy('created_at')->get()->first();
        if ($member) {
            $res->upliner = User::find($member->referral_user_id);
        }

        $level1 = $this->getLevel1Members();
        $level2 = $this->getLevel2Members($level1);
        $level3 = $this->getLevel3Members($level2);
        $totalMembers = sizeof($level1) + sizeof($level2) + sizeof($level3);
        $res->total_members = $totalMembers;
        //deposit and withdraw commissions.
        //$level1Commission = 0;
        $depositCommission = 0;
        $withdrawCommission = 0;
        foreach ($level1 as $member) {
            //$txIds  = Comissions::select('transaction_id as id')->where('member_id', $member->user_id)->pluck('id');
            foreach (TransactionTable::where('user_id', $member->user_id)
            
            ->latest()->get() as $tx) {
                if ($tx->deposit_id > 0 && $tx->type=='Deposit') {
                    //deposit
                    $depositCommission += $tx->avaiable_amount;
                } else if ($tx->withdraw_id > 0 && $tx->type=='withdraw') {
                    $withdrawCommission += $tx->avaiable_amount;
                }
                //   $level1Commission+=$tx->avaiable_amount;
            }
        }
        //  $res->level_1=$level1Commission;
        //    $level2Commission = 0;
        foreach ($level2 as $member) {
            // $txIds  = Comissions::select('transaction_id as id')->where('member_id', $member->user_id)->pluck('id');
            foreach (TransactionTable::where('user_id', $member->user_id)
            
            ->latest()->get() as $tx) {
                if ($tx->deposit_id > 0 && $tx->type=='Deposit') {
                    //deposit
                    $depositCommission += $tx->avaiable_amount;
                } else if ($tx->withdraw_id > 0 && $tx->type=='withdraw') {
                    $withdrawCommission += $tx->avaiable_amount;
                }
                //   $level1Commission+=$tx->avaiable_amount;
            }
        }
        //  $res->level_2=$level2Commission;
        //        $level3Commission = 0;
        foreach ($level3 as $member) {
            //$txIds  = Comissions::select('transaction_id as id')->where('member_id', $member->user_id)->pluck('id');
            foreach (TransactionTable::where('user_id', $member->user_id)
            
            ->latest()->get() as $tx) {
                if ($tx->deposit_id > 0 && $tx->type=='Deposit') {
                    //deposit
                    $depositCommission += $tx->avaiable_amount;
                } else if ($tx->withdraw_id > 0 && $tx->type=='withdraw') {
                    $withdrawCommission += $tx->avaiable_amount;
                }
                //   $level1Commission+=$tx->avaiable_amount;
            }
        }
        //    $res->level_3=$level3Commission;
        $res->deposit_commission = $depositCommission;
        $res->withdraw_commission = $withdrawCommission;
        //$res->total_deposit=TransactionTable::where('deposit_id',"!=",0)->sum('avaiable_amount');
        // $res->total_withdraw=TransactionTable::where('withdraw_id',"!=",0)->sum('avaiable_amount');
        
        return $res;
    }
    function getCommissionsOfAUser($userId)
    {
        $res = new stdClass;
        $res->level_1 = $this->getLeve1Commission();
        $res->level_2 = $this->getLeve2Commission();
        $res->level_3 = $this->getLeve3Commission();
        $member = Member::where('user_id', $userId)->orderBy('created_at')->get()->first();
        if ($member) {
            $res->upliner = User::find($member->referral_user_id);
        }

        $level1 = $this->getLevel1Members();
        $level2 = $this->getLevel2Members($level1);
        $level3 = $this->getLevel3Members($level2);
        $totalMembers = sizeof($level1) + sizeof($level2) + sizeof($level3);
        $res->total_members = $totalMembers;



        return $res;
    }
    function getLeve3Commission()
    {
        $res = new stdClass;
        $level1Members = $this->getLevel1Members();
        $level2Members = $this->getLevel2Members($level1Members);
        $level3Members = $this->getLevel3Members($level2Members);
        // $totalCommission = 0;
        $totalTransactions = array();
        foreach ($level3Members as $member) {
            //get transactions of member
            $transactions = TransactionTable::where('user_id', $member->user_id)
                ->where('investment_id', 0)->get();
            //now check for type=Commision with current user. With same deposit and withdraw id
            foreach ($transactions as $tx) {
                //get all commissions of deposits
                $deposits = TransactionTable::where('deposit_id', $tx->deposit_id)
                    ->where('user_id', Auth::id())
                    ->where('type', 'Commision')
                    ->get();
                //get all commissions of deposits
                $withdraws = TransactionTable::where('withdraw_id', $tx->withdraw_id)
                    ->where('user_id', Auth::id())
                    ->where('type', 'Commision')
                    ->get();
                array_push($totalTransactions, $deposits);
                array_push($totalTransactions, $withdraws);
            }
        }

        $res->transactions = $totalTransactions;

        return $res;
    }

    function getLeve2Commission()
    {
        $res = new stdClass;
        $level1Members = $this->getLevel1Members();
        $level2Members = $this->getLevel2Members($level1Members);

        $totalTransactions = array();
        foreach ($level2Members as $member) {
            //get transactions of member
            $transactions = TransactionTable::where('user_id', $member->user_id)
                ->where('investment_id', 0)->get();
            //now check for type=Commision with current user. With same deposit and withdraw id
            foreach ($transactions as $tx) {
                //get all commissions of deposits
                $deposits = TransactionTable::where('deposit_id', $tx->deposit_id)
                    ->where('user_id', Auth::id())
                    ->where('type', 'Commision')
                    ->get();
                //get all commissions of deposits
                $withdraws = TransactionTable::where('withdraw_id', $tx->withdraw_id)
                    ->where('user_id', Auth::id())
                    ->where('type', 'Commision')
                    ->get();
                array_push($totalTransactions, $deposits);
                array_push($totalTransactions, $withdraws);
            }
        }


        $res->transactions = $totalTransactions;

        return $res;
    }

    function getLeve1Commission()
    {
        $res = new stdClass;
        $level1Members = $this->getLevel1Members();
        $totalCommission = 0;
        $totalTransactions = array();
        foreach ($level1Members as $member) {
            //get transactions of member
            $transactions = TransactionTable::where('user_id', $member->user_id)
                ->where('investment_id', 0)->get();

            //now check for type=Commision with current user. With same deposit and withdraw id
            foreach ($transactions as $tx) {
                //get all commissions of deposits
                $deposits = TransactionTable::where('deposit_id', $tx->deposit_id)
                    ->where('user_id', Auth::id())
                    ->where('type', 'Commision')
                    ->get();
                //get all commissions of deposits
                $withdraws = TransactionTable::where('withdraw_id', $tx->withdraw_id)
                    ->where('user_id', Auth::id())
                    ->where('type', 'Commision')
                    ->get();
                array_push($totalTransactions, $deposits);
                array_push($totalTransactions, $withdraws);
            }
        }

        $res->transactions = $totalTransactions;

        return $res;
    }


    function getCommissionFromAMember($id)
    {
        $commission  = Comissions::where('member_id', $id)
            ->where('user_id', Auth::id())
            ->sum('amount');
        $depositCommission = TransactionTable::where('type', 'Deposit')->where("user_id", $id)->where('deposit_id', '>', 0)->sum('avaiable_amount');


        // foreach (TransactionTable::whereIn('id', $txIds)->latest()->get() as $tx) {
        //     if ($tx->deposit_id > 0) {
        //         //deposit
        //         $depositCommission += $tx->avaiable_amount;
        //     }
        //     $total += $tx->avaiable_amount;
        // }

        return response()->json([
            'total_deposit' => $depositCommission,
            'total' => $commission,
            'currency' => Setting::where('key', 'defualt_currency')->get()->first()->value,
            'currency_symbol' => Setting::where('key', 'default_currency_symbol')->get()->first()->value,
        ]);
    }

    function getLevel1Members()
    {
        //all users invited by me
        return Member::where('referral_user_id', Auth::id())->with(['user'])->get();
    }
    function getLevel2Members($level1Members)
    {
        //All users invited by level 1 members
        $level2Members = array();
        if (sizeof($level1Members) > 0) {
            foreach ($level1Members as $member) {
                foreach (Member::where('referral_user_id', $member->user_id)->with(['user'])->get() as $m) {
                    array_push($level2Members, $m);
                }
            }
        }
        return $level2Members;
    }
    function getLevel3Members($level2Members)
    {
        //All users invited by level 2 members
        $level3Members = array();
        if (sizeof($level2Members) > 0) {
            foreach ($level2Members as $member) {
                foreach (Member::where('referral_user_id', $member->user_id)->with(['user'])->get() as $m) {
                    array_push($level3Members, $m);
                }
            }
        }

        return $level3Members;
    }

    /**
     * Display a listing of the resource.
     */
    public function showMember(Request $request)
    {

        // Constructing the response object
        $level1 = $this->getLevel1Members();
        $level2 = $this->getLevel2Members($level1);
        $level3 = $this->getLevel3Members($level2);
        $response = [
            'level_1' => $level1,
            'level_2' => $level2,
            'level_3' => $level3,
        ];

        // Return response as JSON
        return response()->json($response);
    }



    // total team commission details request
    // public function team_commission_detail(){
    //     try {
    //         $AuthId = Auth::id();

    //         $level1commission = TransactionTable::where('user_id', $AuthId)->get();

    //         // return $level1commission;

    //         // Find the referral_user_ids where the user_id matches the AuthId

    //         $totalReferralUserIdsforlevel2 = Member::where('referral_user_id', $AuthId)->orderBy('id')
    //         ->pluck('user_id')
    //         ->toArray();

    //         // return $totalReferralUserIdsforlevel2;

    //         $totalReferralUserIds = Member::whereIn('referral_user_id', $totalReferralUserIdsforlevel2)
    //         ->orderBy('id')
    //         ->pluck('user_id')
    //         ->toArray();

    //         // return $totalReferralUserIds;

    //         $totalLevelMember2 = Member::where('referral_user_id',$AuthId)->orderBy('id')->pluck('user_id')->count();
    //         // get the total commission of total level member2''
    //         $level2commissions = 

    //         $totalLevelMember3 = Member::where('referral_user_id',$totalLevelMember2)->orderBy('id')->pluck('user_id')->count();

    //         $totalTeamMember = $totalLevelMember2 + $totalLevelMember3;

    //         // return $totalTeamMember;

    //         // Get the IDs of the starting three team members
    //         $startingThreeTeamMembers = Member::where('referral_user_id', $AuthId)
    //             ->orderBy('id') // Order by the ID
    //             ->limit(3) // Limit to the first three records
    //             ->pluck('user_id')->toArray();

    //         // Initialize arrays to store commission values for each level
    //         $levelCommissions = [
    //             'level1' => 0,
    //             'level2' => 0,
    //             'level3' => 0,
    //         ];

    //         foreach ($startingThreeTeamMembers as $index => $teamMemberId) {
    //             // Sum the deposit amounts from the deposit_request table where user_id matches the referral_user_id
    //             $commission = depositrequest::whereIn('user_id', $totalReferralUserIds)
    //                                         ->where('user_id', $teamMemberId)
    //                                         ->sum('depositamount');

    //             // Store commission value in the corresponding level
    //             $levelCommissions['level'.($index+1)] = $commission;
    //         }

    //         // Sum the deposit amounts from the deposit_request table where user_id matches the referral_user_ids
    //         $totalTeamDeposit = TransactionTable::whereIn('user_id', $totalReferralUserIdsforlevel2)->sum('avaiable_amount');

    //         // Calculate total commission across all levels
    //         $totalTeamCommission = array_sum($levelCommissions);

    //         // Prepare the response
    //         $response = [
    //             // 'data' => [
    //             'total_team_deposit' => $totalTeamDeposit,
    //             'total_team_commission' => $totalTeamCommission, // Add total commission
    //             'total_team_member' => $totalTeamMember,
    //             // 'starting_three_team_members' => $startingThreeTeamMembers,
    //             'level_commissions' => $levelCommissions,
    //             // ]
    //         ];

    //         // Return the response as JSON`
    //         return response()->json($response);

    //     } catch (\Exception $ex) {
    //         // Return any exception message as JSON
    //         return response()->json(['message' => $ex->getMessage()]);
    //     }
    // }



    // avaiable_amount

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
