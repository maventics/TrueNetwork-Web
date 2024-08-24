<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use App\Models\Withdrawrequest;
use App\Models\depositrequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $res;
    public function update_setting(Request $request)
    {
        try {

            // Validation rules
            $data = $request->validate([
                'key' => "required|exists:settings,key",
                'value' => "required",

            ]);
            
            if ($data['key'] == 'logo') {
                if ($request->hasFile('logo')) {
                    $image = $request->file('logo');
                    $imageName = time().'.'.$image->getClientOriginalExtension();
                    $path = public_path('/upload_image');
                    $image->move($path, $imageName);
                } else {
                    throw new Exception("Image not provided.");
                }

                
                Setting::where('key',$request->key)->update(['value' => $imageName]);

            }else{
                //update content....

                Setting::where('key',$request->key)->update(['value'=>$request->value]);
            }

            // foreach ($fields as $field) {
            //     if (isset($data[$field])) {
            //         Setting::where('key', $field)->update(['value' => $data[$field]]);
            //     }
            // }

            // // Update application name if provided
            // if (isset($data['app_name'])) {
            //     config(['app.name' => $data['app_name']]);
            // }

            return back()->with('success', 'Settings updated successfully');
        } catch (Exception $ex) {
            return back()->withErrors(['danger' => $ex->getMessage()])->withInput();
        }
    }





    public function settings()
    {

        $settings = Setting::all();
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        return view('setting.setting', compact('settings', 'withdrawrequests', 'depositRequests'));
    }
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
