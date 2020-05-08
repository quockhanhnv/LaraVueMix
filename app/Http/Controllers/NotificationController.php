<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotificationRequest;
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
        $notifications = Notification::with('author')->orderBy('created_at', 'desc')->get();

        return response()->json([
            "notifications" => $notifications
        ], 200);
    }

    public function get($id)
    {
        $notification = Notification::whereId($id)->first();

        DB::table('user_notifications')
            ->where([
                ['user_id', '=', auth()->user()->id],
                ['notification_id', '=', $id],

            ])->update(['status' => READABLE]);

        return response()->json([
            "notification" => $notification
        ], 200);
    }

    public function new(CreateNotificationRequest $request)
    {
        try {
            DB::beginTransaction();

            $notification = new Notification();
            $notification->notification_title = $request->input('notification_title');
            $notification->notification_content = $request->input('notification_content');
            $notification->created_by = Auth::guard('api')->user()->id;

            $notification->save();
            // insert data to role_user table
            $groupNotification = config('group_notification');
            $groupNotification = array_diff($groupNotification, array(ADMIN_ROLE));

            $users = User::whereIn('role', $groupNotification)->get(); // whereIn groupNotification

            $notification->users()->attach($users);

            DB::commit();

            // send mail to all user has role ADMIN_ROLE

            $listEmail = $users->pluck('email')->toArray();

            $link = route('web.notification.get', ['id' => $notification->id]);

            Mail::to($listEmail)->send(new SendMailToNotifications($notification->notification_title, $notification->notification_content, $link));

            return response()->json([
                "notification" => $notification
            ], 200);

        } catch (\Exception $exception) {
            DB::rollBack();
        }

    }
}
