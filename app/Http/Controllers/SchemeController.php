<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use App\Models\schemes;
use App\Models\Withdrawrequest;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Models\depositrequest;
class SchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schemes = schemes::all();
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        return view('schemes.index',compact('schemes','withdrawrequests','depositRequests'));
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
            $this->validate($request, [
                'title' => 'required',
                'sub_title' => 'required',
                'profit' => 'required|numeric',
                'duration' => 'required',
                'user_investment_limit' => 'required',
                'starting_investment' => 'required',
                'ending_investment' => 'required',
                'image' => 'required', // Adjust file types and size as per your requirements
            ]);

            // Store image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $path = public_path('/upload_image');
                $image->move($path, $imageName);
            } 

            // Save to database
            $scheme = new schemes();
            $scheme->title = $request->input('title');
            $scheme->sub_title = $request->input('sub_title');
            $scheme->profit = $request->input('profit');
            $scheme->duration = $request->input('duration');
            $scheme->user_investment_limit = $request->input('user_investment_limit');
            $scheme->starting_investment = $request->input('starting_investment');
            $scheme->ending_investment = $request->input('ending_investment');
            $scheme->bg_image = $imageName; // Assuming 'image' is the column name in your schemes table
            $scheme->save();

            return back()->with('success','Scheme added Successfully..');

        } catch (Exception $ex) {
            // return response()->json(['error' => $th->getMessage()], 500);
            return back()->withInput()->withErrors(['error'=> $ex->getMessage()]);
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
    public function update(Request $request, $id)
    {
        // return $request;
        try {
            $this->validate($request, [
                'title' => 'required',
                'sub_title' => 'required',
                'profit' => 'required',
                'duration' => 'required',
                'user_investment_limit' => 'required',
                'starting_investment' => 'required',
                'ending_investment' => 'required',
                'image' => '', // Adjust file types and size as per your requirements
            ]);

            // Find the scheme by ID
            $scheme = schemes::findOrFail($id);

            // Update image if provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $path = public_path('/upload_image');
                $image->move($path, $imageName);
                // Delete old image if exists
                if ($scheme->image) {
                    unlink(public_path('upload_image/' . $scheme->image));
                }
                $scheme->bg_image = $imageName;
            }


            // Update scheme details
            $scheme->title = $request->input('title');
            $scheme->sub_title = $request->input('sub_title');
            $scheme->profit = $request->input('profit');
            $scheme->duration = $request->input('duration');
            $scheme->user_investment_limit = $request->input('user_investment_limit');
            $scheme->starting_investment = $request->input('starting_investment');
            $scheme->ending_investment = $request->input('ending_investment');

            $scheme->save();

            return back()->with('success', 'Scheme updated Successfully..');

        } catch (\Throwable $th) {
            // return back()->with('error', $th->getMessage());
            return back()->withInput()->withErrors(['error'=> $th->getMessage()]);
        }
    }



    public function updateStatus(string $id) {
        $scheme = schemes::find($id);
        if (!$scheme) {
            return back()->with('alert', 'Scheme not found');
        }

        // Check if the current status is already 0
        // if ($scheme->status == 0) {
        //     return back()->with('success', 'Scheme status is already 0, cannot change the status');
        // }

        // Toggle the status
        $scheme->status = ($scheme->status == 1) ? 0 : 1;
        $scheme->save();

        return back();
    }



    public function view($id)
    {
        // Fetch the scheme record based on the provided ID
        $scheme = schemes::with('investments')->findOrFail($id);

        // Fetch investments associated with the scheme and eager load the corresponding user data
        $Investments = Investment::with('user')->where('scheme_ref_id', $id)->get();

        // Fetch all withdraw requests
        $withdrawRequests = Withdrawrequest::all();

        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();


        // Pass the scheme record, Investments, and withdraw requests to the view
        return view('schemes.show', compact('scheme', 'withdrawRequests', 'Investments','withdrawrequests','depositRequests'));
    }



}
