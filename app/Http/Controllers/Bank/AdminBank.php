<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank\AdminBankDetail;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\Bank;
use App\Models\admin;
use App\Models\depositrequest;
use App\Models\Withdrawrequest;

class AdminBank extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adminbanks = AdminBankDetail::all();
        $admins = admin::all();
        $banks = Bank::all();
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        return view('bank.adminbank',compact('adminbanks','banks','admins','withdrawrequests','depositRequests'));
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
                 'account_title' => 'required',
                 'account_number' => 'required',
                 'bank_id' => 'required|exists:banks,id',
                 'admin_id' => 'required|exists:admins,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()],422);
            }

            $admin_bank_detail = AdminBankDetail::create([
                'account_title'=> $request->account_title,
                'account_number'=> $request->account_number,
                'bank_id'=> $request->bank_id,
                'admin_id'=> $request->admin_id,
            ]);

            return back()->with('message', 'Admin Bank Details created successfully');
        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()], 500);
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
            'account_title' => 'required',
            'account_number' => 'required',
            'bank_id' => 'required|exists:banks,id',
            'admin_id' => 'required|exists:admins,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $Admin_bank_Details = AdminBankDetail::findOrFail($id);
        $Admin_bank_Details->update([
            'account_title'=> $request->account_title,
                'account_number'=> $request->account_number,
                'bank_id'=> $request->bank_id,
                'admin_id'=> $request->admin_id,
        ]);
        return back()->with('success','Admin Bank Details added Successfully..');
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
            AdminBankDetail::where('id',$id)->delete();
            return back()->with('success','Admin bank details Deleted Successfully..');
        } catch(Exception $ex){
            return back()->withErrors(['errors'=> $ex->getMessage()]);
        }
    }
}
