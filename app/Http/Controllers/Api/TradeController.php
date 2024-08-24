<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Comissions;
use App\Models\Investment;
use App\Models\Member;
use App\Models\Setting;
use App\Models\TransactionTable;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
class TradeController extends Controller
{
    protected $res;

    function __construct()
    {
        $this->res = new \stdClass;
    }

    //This function will transact the commission of level 1 and return the user_id
    function transactCommissionToLevel1($investment, $remainingAmount)
    {
        $userId = $investment->user_id;
        ///find upliner of this user with [$userId]
        //check who invited userId. Thats level 1
        $level1Member = Member::where('user_id', $userId)->get()->first();
        if (!$level1Member) {
            return null;
        }
        $percentage = Setting::where('key', 'level_1_commission_percentage')->get()->first()->value;
        $commission = is_numeric($remainingAmount) && is_numeric($percentage) ? ($remainingAmount * ($percentage / 100)) : 0;
        //Credit the commission to upliner
       $tr =TransactionTable::create([
            'user_id' => $level1Member->referral_user_id,
            'type' => "Commision",
            'avaiable_amount' => $commission,
            'status' => 1,
            'investment_id'=>$investment->id,
        ]);
       Comissions::create([
            'user_id'=>$level1Member->referral_user_id,
            'member_id'=>$userId,
            'amount'=>$commission,
            'commission'=>$percentage,
            'level'=>'Level 1',
            'transaction_id'=>$tr->id,
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

    function transactCommissionToLevel2($investment, $level1UserId, $remainingAmount)
    {
        $userId = $investment->user_id;
        ///find upliner of level1UserId for which $userId will be on level 2
        $level2Member = Member::where('user_id', $level1UserId)->get()->first();
        if (!$level2Member) {
            return null;
        }
        $percentage = Setting::where('key', 'level_2_commission_percentage')->get()->first()->value;
        $commission = is_numeric($remainingAmount) && is_numeric($percentage) ? ($remainingAmount * ($percentage / 100)) : 0;
        //Credit the commission to upliner
      $tr=  TransactionTable::create([
            'user_id' => $level2Member->referral_user_id,
            'type' => "Commision",
            'avaiable_amount' => $commission,
            'status' => 1,
            'investment_id'=>$investment->id,
        ]);
        $user = User::find($level2Member->referral_user_id);
        Comissions::create([
            'user_id'=>$level2Member->referral_user_id,
            'member_id'=>$userId,
            'amount'=>$commission,
            'commission'=>$percentage,
            'level'=>'Level 2',
            'transaction_id'=>$tr->id,
        ]);
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser(
            $user->device_token,
            'Your commission received on withdrawal!',
            'PKR' . $commission . ' has been credited into your wallet!',
            null
        );
        return $level2Member;
    }
    function transactCommissionToLevel3($investment, $level2UserId, $remainingAmount)
    {
        $userId = $investment->user_id;
        ///find upliner of level1UserId for which $userId will be on level 2
        //If requirements changes that there  can be multiple level 2s then use foreach here...
        $level3Member = User::find($level2UserId->id);
        if (!$level3Member) {
            return null;
        }
        $percentage = Setting::where('key', 'level_3_commission_percentage')->get()->first()->value;
        $commission = is_numeric($remainingAmount) && is_numeric($percentage) ? ($remainingAmount * ($percentage / 100)) : 0;
        //Credit the commission to upliner
      $tr=  TransactionTable::create([
            'user_id' => $level3Member->id,
            'type' => "Commision",
            'avaiable_amount' => $commission,
            'status' => 1,
            'investment_id'=>$investment->id,
        ]);
        Comissions::create([
            'user_id'=>$level3Member->id,
            'member_id'=>$userId,
            'amount'=>$commission,
            'commission'=>$percentage,
            'transaction_id'=>$tr->id,
            'level'=>'Level 3'
        ]);
        
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser(
            $level3Member->device_token,
            'Your commission received!',
            'PKR' . $commission . ' has been credited into your wallet!',
            null
        );
        return $level3Member;
    }

    ///Distribute deposit commission to team..
    function distributeDepositCommisionToTeam($investment, $remainingAmount)
    {
        $level1UserId = $this->transactCommissionToLevel1($investment, $remainingAmount);
        if ($level1UserId) {
            $level2UserId = $this->transactCommissionToLevel2($investment, $level1UserId, $remainingAmount);
            if ($level2UserId) {
                $level3UserId = $this->transactCommissionToLevel3($investment, $level2UserId, $remainingAmount);
            }
        }
    }

    function claimProfit(Request $request)
    {
        try {
            $this->validate($request, [
                'trade_id' => "required|exists:investments,id",
            ]);
            //update status to 2 and add profit to wallet.
            $trade = Investment::where('user_id', Auth::id())->where('id', $request->trade_id)
                ->where('status', 0)
                ->with(['scheme'])
                ->get()->first();
            if (!$trade) {
                $this->res->error = 'You already claimed the profit!';
                return;
            }
            $trade->status=2;
            $trade->save();
            Investment::where('id', $request->trade_id)->update(['status' => 2]);
            //$trade->update(['status' => 2]);
            //add profit in transaction.
            
            $investmentAmount = floatval($trade->amount);
            $schemeProfitPercentage = floatval($trade->scheme->profit)*floatval($trade->scheme->duration);
            $profit = is_numeric($investmentAmount) && is_numeric($schemeProfitPercentage) ? ($investmentAmount * ($schemeProfitPercentage / 100)) : 0;


            $this->res->message = 'Profit claimed!';
            $tx=TransactionTable::create([
                'type' => "Deposit",
                'avaiable_amount' => $trade->amount,
                'status' => 1,
                'user_id' => Auth::id(),
            ]);
            $this->res->transaction = TransactionTable::create([
                'type' => "Profit",
                'avaiable_amount' => $profit,
                'status' => 1,
                'user_id' => Auth::id(),
                'investment_id' => $trade->id,
            ]);
            //Send push notificaiton
            $user = User::find(Auth::id());
            $notification = new NotificationController();
            $notification->sendNotificationToSingleUser($user->device_token, 'Your profit from ' . $trade->scheme->title . ' has been claimed!', 'PKR' . $profit . ' has been credited into your wallet!', null);

            $this->distributeDepositCommisionToTeam($trade,$profit);
        } catch (Exception $ex) {
            $this->res->error = $ex->getMessage();
        } finally {
            return $this->res;
        }
    }

    function checkExpiredTrades()
    {
        $expiredTrades = Investment::where('status',1)->expired()->get();
        $dry = new NotificationController();

        // $dry->sendNotificationToSingleUser('ea3z-Cx8TfusQ7qNHFTWm0:APA91bFacaikXaR8_LV3h4zxptXObCq7pNmNvgNq98isX5pW9kgtjboPh0jme4pOAeNXGEn8PCWt_U1aJrYkvhoXnXn1G_25D1bgyps2Sr9G1KWkPVuS-QGji6fumuA4MvtuLxm-3_9k', 'as been completed', 'Claim your profit in trades!', '/trades');
        foreach ($expiredTrades as $trade) {
            // Mark the trade as expired (update its status or perform other actions)
            //$trade->update(['status' => 0]);
            
                $trade->status = 0;
                $trade->save();
                $user = User::find($trade->user_id);
                if ($user->device_token) {
                    $dry->sendNotificationToSingleUser($user->device_token, 'Your trade has been completed', 'Claim your profit in trades!', '/trades');
                }
            
            // Perform any other necessary actions, such as notifying users, logging, etc.
        }
    }

    function trades(Request $request)
    {
        try {
            $this->checkExpiredTrades();
            $this->res->running = Investment::where('user_id', \Auth::id())
                ->where('status', 1) // Status 1 means trade running
                ->with(['scheme'])
                ->get()
                ->map(function ($investment) {
                    // Use Carbon to parse and format the created_at attribute
                    $investment->formatted_end_date= Carbon::parse($investment->end_date_timestamp)->format('Y-m-d h:i:s A');
                    return $investment;
                })
                ->map(function ($investment) {
                    // Use Carbon to parse and format the created_at attribute
                    $investment->formatted_created_at = Carbon::parse($investment->created_at)->format('Y-m-d h:i:s A');
                    return $investment;
                })
                ->map(function ($investment) {
                    // Use Carbon to parse and format the created_at attribute
                    $investment->formatted_updated_at = Carbon::parse($investment->update_at)->format('Y-m-d h:i:s A');
                    return $investment;
                });
            $this->res->completed = Investment::where('user_id', \Auth::id())->where('status', 0)  // Status 0 means trade expire/complete
                ->with(['scheme'])
                ->get()
                ->map(function ($investment) {
                    // Use Carbon to parse and format the created_at attribute
                    $investment->formatted_end_date= Carbon::parse($investment->end_date_timestamp)->format('Y-m-d h:i:s A');
                    return $investment;
                })
                ->map(function ($investment) {
                    // Use Carbon to parse and format the created_at attribute
                    $investment->formatted_created_at = Carbon::parse($investment->created_at)->format('Y-m-d h:i:s A');
                    return $investment;
                })
                ->map(function ($investment) {
                    // Use Carbon to parse and format the created_at attribute
                    $investment->formatted_updated_at = Carbon::parse($investment->update_at)->format('Y-m-d h:i:s A');
                    return $investment;
                });
            $this->res->claimed = Investment::where('user_id', \Auth::id())->where('status', 2)  // Status 2 means trade claimed with withdraw
                ->with(['scheme'])
                ->get()
                ->map(function ($investment) {
                    // Use Carbon to parse and format the created_at attribute
                    $investment->formatted_end_date= Carbon::parse($investment->end_date_timestamp)->format('Y-m-d h:i:s A');
                    return $investment;
                })
                ->map(function ($investment) {
                    // Use Carbon to parse and format the created_at attribute
                    $investment->formatted_created_at = Carbon::parse($investment->created_at)->format('Y-m-d h:i:s A');
                    return $investment;
                })
                ->map(function ($investment) {
                    // Use Carbon to parse and format the created_at attribute
                    $investment->formatted_updated_at = Carbon::parse($investment->update_at)->format('Y-m-d h:i:s A');
                    return $investment;
                });
            
        } catch (\Exception $ex) {
            $this->res->error = $ex->getMessage();
        } finally {
            return $this->res;
        }
    }
}
