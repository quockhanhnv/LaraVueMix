<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotificationRequest;
use App\Mail\SendMailToNotifications;
use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function all()
    {
        $notifications = $this->notificationService->withRelation(['author']);
        $notifications = $this->notificationService->orderByField($notifications,'created_at', 'desc')->get();

        return response()->json([
            "notifications" => $notifications
        ], 200);
    }

    public function get($id)
    {
        $notification = $this->notificationService->findById($id);
        $this->notificationService->changeStatus($id);

        return response()->json([
            "notification" => $notification
        ], 200);
    }

    public function new(CreateNotificationRequest $request)
    {
        try {
           $this->notificationService->store($request);

                return response()->json([
                    "message" => 'Created notification successfully'
                ], 200);

        } catch (\Exception $exception) {
            Log::error('Something went wrong when insert notification ' . $exception->getMessage());
        }


    }
}
