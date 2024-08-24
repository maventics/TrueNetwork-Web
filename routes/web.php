<?php

use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Bank\AdminBank;
use App\Http\Controllers\Bank\UserBankController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\TransactionTableController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvestmentController;
use App\Models\TransactionTable;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\SendNotification;
use App\Http\Controllers\usercontroller;
use App\Mail\emails\deposit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     // Assuming PSXWebiste folder is located outside the Laravel project's root directory
//     $path = realpath(__DIR__ . '');

//     // Check if the directory exists
//     if (is_dir($path)) {
//         // Serve the index.html file from the PSXWebiste folder
//         return response()->file($path . '\index.html');
//     } else {
//         // If the directory doesn't exist, return a 404 error
//         abort(404);
//     }
// });


Route::get('/downloadapk', function () {
    $filePath = public_path('images/PSX_I.apk');
    return response()->download($filePath);
})->name('download.apk');


Route::get('/tradeexpire', function () {
    return view('emails.tradeexpire');
})->name('index');


Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/team', function () {
    return view('/webistecontent/team');
})->name('team');

Route::get('/services', function () {
    return view('/webistecontent/services');
})->name('services');

Route::get('/privacypolicy', function () {
    return view('/webistecontent/privacypolicy');
})->name('privacypolicy');

Route::get('/features', function () {
    return view('/webistecontent/features');
})->name('features');

Route::get('/blog', function () {
    return view('/webistecontent/blog');
})->name('blog');

Route::get('/contact', function () {
    return view('/webistecontent/contact');
})->name('contact');



Route::get('/admin', [LoginController::class, 'index'])->name('admin.login-view');
Route::POST('/admin', [LoginController::class, 'adminLogin'])->name('admin.login');
Auth::routes();



// Route::get('/login', [LoginController::class, 'index'])->name('admin.login-view');

Route::group(['middleware' => ['auth:admin']], function () {


    Route::POST('/admin/logout', [LoginController::class, 'Logout'])->name('logout');

    Route::get('/admin/dashboard', [HomeController::class, 'app'])->name('layout.app');

    Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('home.page');
    Route::get('/admin/profile_update/view', [LoginController::class, 'profile_update_view']);
    Route::post('admin/update_profile', [LoginController::class, 'update_profile'])->name('update_profile');

    // user management routes
    Route::get('/admin/user/index',[usercontroller::class, 'index'])->name('users.index');

    Route::get('/admin/user/details/depositrequest',[usercontroller::class, 'depositRequest']);
    Route::get('/admin/user/details/transactiontable',[usercontroller::class, 'TransactionHistory']);
    Route::get('/admin/user/details/trade',[usercontroller::class, 'Trade']);
    Route::get('/admin/user/details/withdrawrequest',[usercontroller::class, 'withdrawRequest']);
    
    Route::POST('/admin/user/store',[usercontroller::class, 'store']);
    Route::put('/admin/user/update{id}',[usercontroller::class, 'update'])->name('user.update');
    Route::get('/admin/user/edit/{id}',[usercontroller::class, 'edit'])->name('users.edit');
    Route::delete('/admin/user/destroy{id}',[usercontroller::class,'destroy'])->name('user.destroy');
    Route::get('/admin/user/view/{id}',[usercontroller::class, 'view']);
    Route::get('admin/update-status/{id}', [usercontroller::class, 'updatestatus']);



    Route::get('/admin/user/index', [usercontroller::class, 'index']);
    Route::POST('/admin/user/store', [usercontroller::class, 'store']);
    Route::put('/admin/user/update{id}', [usercontroller::class, 'update'])->name('user.update');
    Route::delete('/admin/user/destroy{id}', [usercontroller::class, 'destroy'])->name('user.destroy');
    Route::get('/admin/user/view/{id}', [usercontroller::class, 'view']);
    Route::post('/update-user-status/{id}', [usercontroller::class, 'changestatusofuser']);
    Route::post('/update-switch-status', [usercontroller::class, 'updateSwitchStatus']);

    // scheme management routes
    Route::get('/admin/scheme/index', [SchemeController::class, 'index']);
    Route::POST('/admin/scheme/store', [SchemeController::class, 'store']);
    Route::put('/admin/scheme/update{id}', [SchemeController::class, 'update'])->name('scheme.update');
    Route::delete('/admin/scheme/destroy{id}', [SchemeController::class, 'destroy'])->name('scheme.destroy');
    Route::get('/admin/scheme/view/{id}', [SchemeController::class, 'view']);
    Route::get('/update-scheme-status/{id}', [SchemeController::class, 'updateStatus'])->name('scheme.updatestatus');
    // bank routes
    Route::get('/admin/bank/index', [BankController::class, 'index']);
    Route::POST('/admin/bank/store', [BankController::class, 'store']);
    Route::put('/admin/bank/update{id}', [BankController::class, 'update'])->name('bank.update');
    Route::delete('/admin/bank/destroy{id}', [BankController::class, 'destroy'])->name('bank.destroy');

    // Admin Bank Routes
    Route::get('/admin/adminbank/index', [AdminBank::class, 'index']);
    Route::POST('/admin/adminbank/store', [AdminBank::class, 'store']);
    Route::put('/admin/adminbank/update{id}', [AdminBank::class, 'update'])->name('adminbank.update');
    Route::delete('/admin/adminbank/destroy{id}', [AdminBank::class, 'destroy'])->name('adminbank.destroy');

    //  Send Notification Route
    Route::get('/admin/sendnotification/index', [SendNotification::class, 'index']);
    Route::POST('/admin/sendnotification/store', [SendNotification::class, 'store']);


    //  User Bank Details Route
    Route::get('/admin/userbank/index', [UserBankController::class, 'index']);

    //  Investment Route
    Route::get('/admin/investment/index', [InvestmentController::class, 'index']);
    Route::post('/update-deposit-status/{id}', [DepositController::class, 'changeStatusOfDeposit']);
    Route::post('/update-status/{id}', [DepositController::class, 'updatestatus']);
    Route::post('/update-status-rejected/{id}', [DepositController::class, 'updatestatusforrejected']);
    Route::post('/update-withdraw-status/{id}', [WithdrawController::class, 'changeStatusOfWithdraw']);
    Route::get('/update-investment-status/{id}', [InvestmentController::class, 'updateStatus'])->name('investment.updateStatus');


    // Deposit Route

    Route::get('/admin/deposit/index',[DepositController::class,'index']);
    Route::get('/admin/deposit/view{id}',[DepositController::class, 'view']);
    // Route::get('/admin/deposit/update-status/{id}', [DepositController::class, 'updatestatus']); // tHIS IS MINE FUCNTION TO UPDATE THE STATUS
    Route::get('/admin/deposit/update-status/{id}', [DepositController::class, 'changeStatusOfDeposit']); // IT'S JAN BHAI API


     // Withdraw Route
     Route::get('/admin/withdraw/index',[WithdrawController::class,'index']);
     Route::get('/admin/withdraw/view{id}',[WithdrawController::class, 'view']);
    //  Route::get('/admin/withdraw/update-status/{id}', [WithdrawController::class, 'updatestatus']); // tHIS IS MINE FUCNTION TO UPDATE THE STATUS
     Route::get('/admin/withdraw/update-status/{id}', [WithdrawController::class, 'changeStatusOfWithdraw']); // IT'S JAN BHAI API
     Route::POST('/update-status-rejected-withdraw/{id}', [WithdrawController::class, 'updatestatusforrejected']); // IT'S JAN BHAI API
     



    Route::get('/admin/deposit/index', [DepositController::class, 'index']);
    Route::get('/admin/deposit/view{id}', [DepositController::class, 'view']);

    // Withdraw Route
    Route::get('/admin/withdraw/index', [WithdrawController::class, 'index']);
    Route::get('/admin/withdraw/view{id}', [WithdrawController::class, 'view']);


    Route::get('/admin/temporary/update-status/{id}',[usercontroller::class, 'updateStatus']);


    Route::get("/admin/transactiontable",[TransactionTableController::class,'index'])->name('transaction.index');

    // Setting Routes
    Route::get('/admin/settings', [SettingController::class, 'settings']);
    Route::post('/admin/update_setting', [SettingController::class, 'update_setting'])->name('update_setting');
   

});

Route::get('/invite', [SignUpController::class, 'signUp']);
Route::POST('/signup/store', [SignUpController::class, 'store']);

Route::get('/invite-link', function () {
    $id = 'TMtc0GMj';
    return redirect('https://psxweb.pakistanstockexchangeinvesters.com/?id=TMtc0GMj#/email-login');
})->name('invite-link');

Route::get('/test-fcm', function () {
    $notification = new NotificationController();
    //$res =   $notification->sendNotificationToSingleUser('fYjwPAAXQGKqrOJl_HHbA6:APA91bEoMCL1Rs8cMPtzck4v2LyORjzKJrL7fJd8gSeD7fHA_riiZWSEU4hOxsolwoBbvQy8Srpw6Ka49IVNkcnhAD2sG4QGmGPttqvwCw9zzm4T9GJyFJpn2BGkSKK3uqe0Ds5cNFQO', "Teasdfsst", "test", null);
    $user=User::find(2);
    
    $res=$notification->sendNotificationToSingleUser($user->device_token, 'Your deposit request has been approved!', 'PKR2500'  . ' has been credited into your wallet!', null);
    echo json_encode($res);
});
