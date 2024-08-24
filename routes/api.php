<?php

use App\Http\Controllers\Api\PasswordRestApiController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\DepositController;
use App\Http\Controllers\Api\InvestmentController;
use App\Http\Controllers\Api\TradeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SchemeController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ManageMemberController;
use App\Http\Controllers\Api\User_Bank_Details;
use App\Http\Controllers\Api\WithdrawController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\usercontroller as ControllersUsercontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Referral Link
Route::POST('/CheckLink',[loginController::class,'CheckLink']);


// Route::POST('register',[LoginController::class,'Register']);
Route::post("signup-with-email",[LoginController::class,'emailSignUp']);
Route::post("login-with-email",[LoginController::class,'emailLogin']);
// Route::POST('signIn',[LoginController::class,'signIn']);

Route::middleware('auth:sanctum')->group(function(){

Route::get('/notifications',[NotificationController::class,'getNotifications']);
Route::post('/mark-as-read',[NotificationController::class,'markAsRead']);

// user Routes
Route::get('get_user',[UserController::class, 'get_user']);
Route::POST('update_user/{id}',[UserController::class, 'update_user']);
Route::POST('upload-profile-image',[UserController::class, 'upload_profile_image']);
Route::get('show_user_avaiable_amount',[Usercontroller::class, 'user_available_amount']);


Route::get('user_transaction_history',[usercontroller::class, 'transaction_history']);


Route::get('active_trade',[usercontroller::class, 'active_trade']);


// Scheme Route
Route::get('get_scheme',[schemecontroller::class, 'get_scheme']);

// Investment Routes
Route::POST('store_investment',[InvestmentController::class, 'store']);
Route::get('total_investment_count',[InvestmentController::class,'total_investment_count']);

// Investment Route
Route::get('/trades',[TradeController::class,'trades']);
Route::post("/claim-profit",[TradeController::class,'claimProfit']);

 // push notification routes
Route::POST('/store_token', [UserController::class, 'updateDeviceToken'])->name('store.token');

//  withdraw request route store
Route::POST('/withdraw_request',[WithdrawController::class,'store']);

// Deposit route
Route::POST('/deposit_request',[DepositController::class,'store']);

// show Member Route
Route::get('/show-member', [ManageMemberController::class, 'showMember'])->name('show.member');
Route::get('/get-commission-by-level',[ManageMemberController::class,'getCommissions']);
Route::get('/get-member-commissions/{id}',[ManageMemberController::class,'getCommissionFromAMember']);

//Banks Apis
Route::get('/get-available-banks',[BankController::class,'get_available_banks']);
Route::get('/get-bank-accounts',[BankController::class,'get_bank_accounts_of_admin']);
Route::get('/get-my-bank-accounts',[BankController::class,'get_bank_accounts_of_mine']);
Route::get('/get-banks',[BankController::class,'get_banks']);
Route::post('/save-my-bank-account',[BankController::class,'save_account']);
Route::delete('/delete-my-account/{id}',[BankController::class,'delete_my_account']);

Route::POST('user_bank_details',[User_Bank_Details::class, 'store']);
Route::post('/user-change-bank/{id}',[User_Bank_Details::class,'update_user_bank']);

// Team and commission details
Route::get('/team_commission_details',[ManageMemberController::class, 'team_commission_detail']);

//  withdraw request route store
Route::get('/withdraw_request',[WithdrawController::class,'index']);

// get Deposit route
Route::get('/deposit_request',[DepositController::class,'index']);
// get Withdraw request
Route::POST('/create_password',[PasswordRestApiController::class,'create_password']);
// get Setting 
Route::get('/get_setting',[ UserController::class,'get_setting']);
// get_latest_android_version
Route::get('/get_latest_android_version',[UserController::class,'get_latest_android_version']);

// testing route
// Route::get('/test',[ManageMemberController::class,'commissiontest']);

// Debug the code 
Route::get('/checkDepositGoalReward',[\App\Http\Controllers\DepositController::class,'checkDepositGoalReward']);

});

// Password Reset Api
Route::POST('/password-reset-api',[PasswordRestApiController::class,'passwordResetOtp']);
Route::post('/email_otp_verified',[PasswordRestApiController::class, 'email_otp_verified']);

