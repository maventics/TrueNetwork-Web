<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Withdrawrequest;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\depositrequest;
class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = Bank::all();
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        return view('bank',compact('banks','withdrawrequests','depositRequests'));
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
        try {
            $validator = Validator::make($request->all(), [
                'bank' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $bank = Bank::create([
                'bank' => $request->bank,
                'status' => $request->status,
            ]);

            return back()->with('success','Bank added Successfully..');

        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
    try {
        $validator = Validator::make($request->all(), [
            'bank' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $bank = Bank::findOrFail($id);
        $bank->update([
            'bank' => $request->bank,
            'status' => $request->status,
        ]);
        return back()->with('success','Bank added Successfully..');
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            Bank::where('id',$id)->delete();
            return back()->with('success','Bank Deleted Successfully..');
        } catch(Exception $ex){
            return back()->withErrors(['errors'=> $ex->getMessage()]);
        }
    }
}
