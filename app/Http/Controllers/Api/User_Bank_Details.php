<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\bank\User_Bank_Details as UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
class User_Bank_Details extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'account_title' => 'required',
            'account_number' => 'required',
            'bank_id' => 'required',
            // 'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $authId = Auth::id();

        $user_bank_detail = UserDetails::create([
            'account_title' => $request->account_title,
            'account_number' => $request->account_number,
            'bank_id' => $request->bank_id,
            'user_id' => $authId,
        ]);

        return response()->json(['message' => 'User Bank Detail created successfully', 'data' => $user_bank_detail], 201);
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
    public function update_user_bank(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'account_title' => 'required',
        'account_number' => 'required',
        'bank_id' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $authId = Auth::id();

    $user_bank_detail = UserDetails::where('id', $id)
                        ->where('user_id', $authId)
                        ->get()
                        ->first();

    if (!$user_bank_detail) {
        return response()->json(['error' => 'User Bank Detail not found'], 404);
    }

    $user_bank_detail->account_title = $request->account_title;
    $user_bank_detail->account_number = $request->account_number;
    $user_bank_detail->bank_id = $request->bank_id;

    $user_bank_detail->save();

    return response()->json(['message' => 'User Bank Detail updated successfully', 'data' => $user_bank_detail], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
