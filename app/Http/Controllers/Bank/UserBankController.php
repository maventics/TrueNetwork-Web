<?php

namespace App\Http\Controllers\bank;

use App\Http\Controllers\Controller;
use App\Models\Bank\User_Bank_Details;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Withdrawrequest;
use App\Models\depositrequest;

class UserBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    /**
     * Show the form for creating a new resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User_Bank_Details::select('id','account_title','account_number','bank_id','user_id')->get();
    
            return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addColumn('action', function ($row){
                return $row->user->name;
            })
            ->addColumn('bank', function ($row){
                return $row->bank->bank;
            })
        
                ->rawColumns(['bank','action'])
                ->make(true);
        }
    
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
    
        return view('bank.userbank',compact('withdrawrequests','depositRequests'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
