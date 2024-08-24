<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank\AdminBankDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Bank;
use App\Models\depositrequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\TransactionTable;
use App\Mail\emails\deposit;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = depositrequest::where('user_id',Auth::id())
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
        try{
            $validator = Validator::make($request->all(), [
                'bank_id' => 'required',
                'accountholder' => 'required',
                'accountnumber' => 'required',
                'depositamount' => 'required',
                'description',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $bank = AdminBankDetail::find($request->bank_id);
            if (!$bank) {
                return response()->json(['error' => 'Invalid Bank Selected'], 422);
            }

            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload_image'), $imageName);

            $user = Auth::user();
            // $auth_id = Auth::id();
            $totalDeposit = $request->depositamount;

            if (!$user) {
                return response()->json(['error' => 'User not authenticated.'], 401);
            }

            $depositRequest = DepositRequest::create([
                'user_id' => $user->id,
                'bank_id' => $request->bank_id,
                'accountholder' => $request->accountholder,
                'accountnumber' => $request->accountnumber,
                'depositamount' => $totalDeposit,
                'description' => $request->description,
                'image' => $imageName,
            ]);

            return response()->json(['message' => 'Deposit added successfully', 'data' => $depositRequest], 201);
        }catch(Exception $ex){
            return response()->json([
                'error'=>$ex->getMessage()
            ]);
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
