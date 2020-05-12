<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotificationRequest;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;
use App\Traits\ResponseTrait;

class NotificationController extends Controller
{
    use ResponseTrait;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function all()
    {
        $notifications = $this->notificationService->withRelation(['author']);
        $notifications = $this->notificationService->orderByField($notifications,'created_at', 'desc')->get();

        return $this->responseSuccess('Get the notification list successfully', $notifications);
    }

    public function get($id)
    {
        $notification = $this->notificationService->findById($id);
        if($notification) {
            $this->notificationService->changeStatus($id);
            return $this->responseSuccess('Get the notification detail successfully', $notification);
        }
        return $this->responseNotFound();
    }

    public function new(CreateNotificationRequest $request)
    {
        try {
           $this->notificationService->store($request);
           return $this->responseSuccess('Created notification successfully');

        } catch (\Exception $exception) {
            Log::error('Something went wrong when insert notification ' . $exception->getMessage());
        }
    }
}
