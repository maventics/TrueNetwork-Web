<?php

namespace App\Http\Controllers;

use App\Models\NotificationModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use stdClass;

class NotificationController extends Controller
{

    protected $res;
    function __construct()
    {
        $this->res = new stdClass;
    }


    ///
    function markAsRead()
    {
        NotificationModel::where(
            'user_id',Auth::id()
        )->update([
            'is_read'=>1
        ]);
        $this->res->message='Marked as read!';
        return $this->res;
    }
    function getNotifications()
    {
        return NotificationModel::where([
            'user_id' => Auth::id(),
            'is_read' => 0
        ])
        ->latest()
        ->get();
    }

    ///Ye function call kro agr kesi ek user ko push notification sent krna h to
    ///Ye function db m bhi notification save krdega.
    /// [title] m title jaega, [description] m description jaega. [payload] m hum commands bhejengy agr bhengni hongi nhi to null krdena.
    public function sendNotificationToSingleUser($userToken, $title, $description, $payload)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=AAAABmDste4:APA91bGcXkxulcwZy-XwdLVTj102k6wlTnzDdSuIr2Qo9UBkiAQZ0VHAKnqy2Wv4VscgBrHMPwPdTUAGuGirf_Jzt2qS7xHaoKT3J8j4e5xS7xGy267vWtDf2-EfL7lob0AZ4unXi8qT',
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => $userToken,
                'notification' => [
                    'title' => $title,
                    'body' => $description,

                ],
                'payload' => $payload,
                'data' => [
                    'title' => $title,
                    'body' => $description,
                ],
            ]);
            $this->res->fcm_response = $response;
            ///Upar notification ki node foreground notification bhejegi or data wali background.

            ///user get kro fcm token se
            $user = User::where('device_token', $userToken)->get()->first();
            if ($user) {
                //save notification
                $this->res->notification =   NotificationModel::create([
                    'user_id' => $user->id,
                    'title' => $title,
                    'description' => $description,
                    'payload' => $payload,

                ]);
            }

            $this->res->success = 'Notification has been sent!';
        } catch (Exception $ex) {
            $this->res->error = $ex->getMessage();
        } finally {
            return $this->res;
        }
    }
}
