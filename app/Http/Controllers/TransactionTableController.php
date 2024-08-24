<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\depositrequest;
use App\Models\TransactionTable;
use App\Models\Withdrawrequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use User;
class TransactionTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
    
        if ($request->ajax()) {
            $data = TransactionTable::select('*');
    
            return DataTables::of($data)
                // ->editColumn('user_id', function($row) {
                //     return User::find($row->user_id)->name;
                // })
                ->addColumn('action', function($row) {
                    $statusText = ($row->status == 1) ? 'Active' : 'In-active';
                    $btnClass = ($row->status == 1) ? 'success' : 'danger';
                    return '<a href="/admin/update-status/'.$row->id.'" class="badge btn-sm btn-'.$btnClass.'">'.$statusText.'</a>';
                })
                // ->rawColumns(['user_id','action'])
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('transactiontable.index', compact("withdrawrequests", "depositRequests"));
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
