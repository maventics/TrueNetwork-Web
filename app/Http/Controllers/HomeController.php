<?php

namespace App\Http\Controllers;

use App\Models\depositrequest;
use App\Models\Investment;
use App\Models\Sale;
use App\Models\Withdrawrequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $withdrawrequests = Withdrawrequest::where('status',0)->get();
        $depositRequests = depositrequest::where('status',0)->with(['bank','user'])->get();
        $orders=Investment::where('end_date_timestamp',">",Carbon::now())->count();
        $profit=Sale::sum('profit');
        return view('home',compact('withdrawrequests','depositRequests','orders','profit'));
    }


    // Controller for App only for withdrawrequest & depositrequest
    public function app()
    {
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        $orders=Investment::where('end_date_timestamp',">",Carbon::now())->count();
        return view('layout.app',compact('withdrawrequests','depositRequests','orders'));
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
