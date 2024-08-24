<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\schemes;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;use Illuminate\Auth\Middleware\Authenticate;


class SchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $res;
    public function get_scheme()
    {
        
        try {
            // Fetch count of investments for the user
            //$countInvestment = Investment::where('scheme_ref_id', $userId)->count();

            // Fetch all schemes
            $data = schemes::latest()->get();

            $countTotalScheme = schemes::all();
            // Optionally, you can add the investment count to each scheme object
            foreach ($data as $scheme) {
                $scheme->investment_count = Investment::where('scheme_ref_id', $scheme->id)->count();
                $scheme->i_invested_count = Investment::where('user_id',Auth::id())->count();
            }

            $this->res = [
                'Total Scheme' => $countTotalScheme,
                'Scheme Details' => $data
            ];
            // $this->res = $data;
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
