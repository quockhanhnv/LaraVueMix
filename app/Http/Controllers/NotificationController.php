<?php

namespace App\Http\Controllers;

use App\Mail\SendMailToNotifications;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function all()
    {
        $customers = Notification::with('author')->orderBy('created_at', 'desc')->get();

        return response()->json([
            "notifications" => $customers
        ], 200);
    }

    public function get($id)
    {
        $customer = Notification::whereId($id)->first();

        return response()->json([
            "customer" => $customer
        ], 200);
    }

    public function new(Request $request)
    {

        try {
            DB::beginTransaction();
            //create a notification
            $notification = new Notification();
            $notification->notification_title = $request->input('notification_title');
            $notification->notification_content = $request->input('notification_content');
            $notification->created_by = Auth::guard('api')->user()->id;

            $notification->save();
            // insert data to role_user table
            $users = User::where('role', ADMIN_ROLE)->get();

            $notification->users()->attach($users);

            DB::commit();

            // send mail to all user has role ADMIN_ROLE

//            $listEmail = $users->pluck('email')->toArray();
//
//            Mail::to('quockhanhnv0209@gmail.com')->send(new SendMailToNotifications($notification->notification_title, $notification->notification_content));
            return response()->json([
                "notification" => $notification
            ], 200);

        } catch (\Exception $exception) {
            DB::rollBack();
        }

    }
}
