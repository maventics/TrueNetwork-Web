<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\TransactionTable;
use Illuminate\Http\Request;
use stdClass;
use App\Models\User;
class ManageMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function getCommissionsOfAUser($userId)
    {
        $res = new stdClass;
        $res->level_1 = $this->getLeve1Commission($userId);
        $res->level_2 = $this->getLeve2Commission($userId);
        $res->level_3 = $this->getLeve3Commission($userId);
        $member=Member::where('user_id',$userId)->orderBy('created_at')->get()->first();
        if($member){
            $res->upliner=User::find($member->referral_user_id);
        }
        
        $level1 = $this->getLevel1Members($userId);
        $level2 = $this->getLevel2Members($level1);
        $level3 = $this->getLevel3Members($level2);
        $totalMembers=sizeof($level1)+sizeof($level2)+sizeof($level3);
        $res->total_members=$totalMembers;
        
        

        return $res;
    }

    /**
     * Show the form for creating a new resource.
     */
    function getLeve3Commission($userId)
    {
        $res = new stdClass;
        $level1Members = $this->getLevel1Members($userId);
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
                    ->where('user_id', $userId)
                    ->where('type', 'Commision')
                    ->get();
                //get all commissions of deposits
                $withdraws = TransactionTable::where('withdraw_id', $tx->withdraw_id)
                    ->where('user_id', $userId)
                    ->where('type', 'Commision')
                    ->get();
                array_push($totalTransactions, $deposits);
                array_push($totalTransactions, $withdraws);
            }
        }

        $res->transactions = $totalTransactions;

        return $res;
    }
    /**
     * Store a newly created resource in storage.
     */    function getLeve2Commission($userId)
    {
        $res = new stdClass;
        $level1Members = $this->getLevel1Members($userId);
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
                    ->where('user_id', $userId)
                    ->where('type', 'Commision')
                    ->get();
                //get all commissions of deposits
                $withdraws = TransactionTable::where('withdraw_id', $tx->withdraw_id)
                    ->where('user_id', $userId)
                    ->where('type', 'Commision')
                    ->get();
                array_push($totalTransactions, $deposits);
                array_push($totalTransactions, $withdraws);
            }
        }


        $res->transactions = $totalTransactions;

        return $res;
    }

    /**
     * Display the specified resource.
     */
    function getLeve1Commission($userId)
    {
        $res = new stdClass;
        $level1Members = $this->getLevel1Members($userId);
        $totalCommission = 0;
        $totalTransactions = array();
        foreach ($level1Members as $member) {
            //get transactions of member
            // return $userId;
            $transactions = TransactionTable::where('user_id', $member->user_id)
                ->where('investment_id', 0)->get();

            //now check for type=Commision with current user. With same deposit and withdraw id
            foreach ($transactions as $tx) {
                //get all commissions of deposits
                $deposits = TransactionTable::where('deposit_id', $tx->deposit_id)
                ->where('type', 'Commission')
                ->where('user_id', $userId)
                ->get();

                //get all commissions of deposits
                $withdraws = TransactionTable::where('withdraw_id', $tx->withdraw_id)
                    ->where('user_id', $userId)
                    ->where('type', 'Commision')
                    ->get();

                // $final_Deposit = $wit
                array_push($totalTransactions, $deposits);
                array_push($totalTransactions, $withdraws);
            }
            
        }

        $res->transactions = $totalTransactions;

        return $res;
    }

    function getLevel1Members($userId)
    {
        //all users invited by me
        return Member::where('referral_user_id', $userId)->with(['user'])->get();
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
    public function showMember(Request $request , $userId)
    {

        // Constructing the response object
        $level1 = $this->getLevel1Members($userId);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
