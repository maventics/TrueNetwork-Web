<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\schemes;
use App\Models\Investment;
use App\Models\TransactionTable;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\emails\tradestart;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class   InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $res;
    public function total_investment_count()
    {
        try {
            $data = Investment::all()->count();

            $this->res = [
                'total_investment_count' => $data,
            ];
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

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'scheme_ref_id' => 'required|exists:schemes,id',
            'amount' => 'required|numeric|min:0.01', // Ensure amount is numeric and minimum 0.01
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $scheme = Schemes::findOrFail($request->scheme_ref_id);


        //check if scheme is locked
        if ($scheme->status == 0) {
            return response()->json(['error' => 'Scheme is locked!']);
        }

        //If scheme has active trade already then dont allow for another one.
        if (Investment::where('user_id', Auth::id())
            ->where('scheme_ref_id', $scheme->id)
            ->where('status', 1) // Status 1 means trade running
            ->exists()
        ) {
            return response()->json(['error'=>"You already invested in this scheme. Let your trade be completed first!"]);
        }
        // Calculate the expiration time based on the current date and scheme duration
        $expirationTime = Carbon::now()->addDays($scheme->duration);

        $userId = Auth::id();
        $checkAvailableAmount = TransactionTable::where('user_id', $userId)->sum('avaiable_amount');

        if ($checkAvailableAmount < $request->amount) {
            return response()->json(['error' => 'You have insufficient available amount'], 400);
        }

        $checkInvestmentLimit = Schemes::where('id', $request->scheme_ref_id)->value('user_investment_limit');
        $countInvestment = Investment::where('scheme_ref_id', $request->scheme_ref_id)
            ->where('user_id', Auth::id())->count();

        if ($checkInvestmentLimit == $countInvestment) {
            return response()->json(['error' => 'You have reached the investment limit for this scheme. Please try another scheme'], 400);
        }



        try {
            // Begin a database transaction
            //DB::beginTransaction();

            //  // Deduct the investment amount from the user's available deposit amount
            //  TransactionTable::where('user_id', $userId)
            //      ->where('type', 'deposit')
            //      ->first()
            //      ->decrement('avaiable_amount', $request->amount);



            // Create the investment record
            $investment = Investment::create([
                'user_id' => $userId,
                'scheme_ref_id' => $request->scheme_ref_id,
                'amount' => $request->amount,
                'end_date_timestamp' => $expirationTime,
            ]);
            TransactionTable::create([
                'user_id' => $userId,
                'type' => 'invest',
                'status' => 1,
                'avaiable_amount' => -$request->amount, // Multiply by -1 to denote deduction
                'investment_id' => $investment->id
            ]);

            // Commit the transaction
            //DB::commit();

            // Send notification to the user via email (assuming you have implemented this)
            $user = Auth::user();
            Mail::to($user->email)->send(new TradeStart($user, $investment));

            // Return success response
            return response()->json(['message' => 'Trade created successfully', 'data' => $investment], 201);
        } catch (\Exception $ex) {
            // Return error response
            return response()->json(['message' => $ex->getMessage()], 500);
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
