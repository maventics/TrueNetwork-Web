<?php

namespace App\Http\Controllers;

use App\Models\SendNotification as ModelsSendNotification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Withdrawrequest;
use App\Models\depositrequest;
class SendNotification extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        return view('notification.sendnotification',compact('users','withdrawrequests','depositRequests'));
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
    $input = $request->all();
    $user_ids = $request->input('user_ids');
    $input['user_id'] = implode(',', $user_ids);
    
    foreach ($user_ids as $user_id) {
        $user = User::findOrFail($user_id);
        
        $notification = new NotificationController();
        $notification->sendNotificationToSingleUser(
            $user->device_token,
            $request->title,
            $request->description,
            null
        );
    }
    
    // ModelsSendNotification::create($input);
    
    return redirect()->back()->with('success', 'Notifications sent successfully.');
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
