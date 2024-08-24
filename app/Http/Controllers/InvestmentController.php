<?php

namespace App\Http\Controllers;

use App\Models\schemes;
use Illuminate\Http\Request;
use App\Models\Investment;
use App\Models\Withdrawrequest;
use App\Models\depositrequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\NotificationController;
use App\Mail\emails\tradeExpire;
use Carbon\Carbon;
use Auth;
use Flasher\Toastr\Laravel\Facade\Toastr;
use Yajra\DataTables\Facades\DataTables;

class InvestmentController extends Controller
{

    public function updateStatus(string $id)
    {
        $investment = Investment::find($id);
        // $get_user = $investment->user_id;

        // Check if the current status is already 0
        if ($investment->status == 0) {
            return back()->with('success', 'Trade status is already 0, cannot change the status');
        }


        // Toggle the status
        $investment->status = ($investment->status == 1) ? 0 : 1;
        $investment->save();



        $user = User::find($investment->user_id);
        // return $user;
        Mail::to($user->email)->send(new tradeExpire($user, $investment));

        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser($user->deviceToken, 'Your trade has been ' . ($investment->status ? 'approved!' : 'rejected!'), 'PKR' . $investment->amount . ' has been ' . ($investment->status ? 'credited into your wallet!' : 'not credited into your wallet!'), null);


        if ($investment->status == 0) {
            return back()->with('success', 'Trade is completed by the admin');
        }
        return back();
    }




    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {


    //     $investments = Investment::all();
    //     $withdrawrequests = Withdrawrequest::all();
    //     $depositRequests = depositrequest::all();   

    //     return view('investment.index',compact('investments','withdrawrequests','depositRequests'));
    // }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Investment::query();

            return DataTables::of($data)
                ->order(function ($query) {
                    $query->orderBy('created_at', 'DESC'); // Replace with your custom column
                })
                ->editColumn('action', function ($row) {
                    if ($row->status == 1) {
                        return '<a href="/update-investment-status/' . $row->id . '" class="btn btn-sm btn-primary">
                        <i class="fas fa-check-circle text-light"></i> Mark as completed
                    </a>';
                    } else {
                        return '<button type="button" class="btn btn-sm btn-light">Trade is completed</button>';
                    }
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 0) {
                        return 'Completed';
                    } else {
                        return 'Running';
                    }
                })
                ->editColumn('user_id', function ($row) {
                    return User::find($row->user_id)->name;
                })
                ->editColumn('scheme_ref_id', function ($row) {
                    return schemes::find($row->scheme_ref_id)->title;
                })
                ->editColumn('duration', function ($row) {
                    return schemes::find($row->scheme_ref_id)->duration;
                })
                ->editColumn('formatted_end_date', function ($row) {
                    return Carbon::parse($row->end_date_timestamp)->format('Y-m-d h:i:s A');
                })
                ->editColumn('profit', function ($row) {
                    $investmentAmount = floatval($row->amount);
                    $schemeProfitPercentage = floatval($row->scheme->profit);
                    $profit = is_numeric($investmentAmount) && is_numeric($schemeProfitPercentage)
                        ? ($investmentAmount * ($schemeProfitPercentage / 100))
                        : 0;
                    return number_format($profit);
                })

                ->rawColumns(['status', 'user_id', 'scheme_ref_id', 'duration', 'profit', 'action', 'formatted_end_date'])
                ->make(true);
        }

        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();


        return view('investment.index', compact('withdrawrequests', 'depositRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function updatestatus($id) {
    //     $investment = Investment::find($id);
    //     if ($investment) {
    //         if ($investment->status) {
    //             $investment->status = 0;
    //         }else {
    //             $investment->status = 1;
    //         }
    //         $investment->save();
    //     }

    //     return back();
    //  }
    /**
     * Store a newly created resource in storage.
     */


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
