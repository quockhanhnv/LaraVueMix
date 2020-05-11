<?php

namespace App\Services;

use App\Mail\SendMailToNotifications;
use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NotificationService extends BaseService {

    protected $userService;

    public function __construct(NotificationRepositoryInterface $repository, UserService $userService)
    {
        $this->repository = $repository;
        $this->userService = $userService;
    }

    public function withRelation($relation)
    {
        return $this->repository->withRelation($relation);
    }

    public function filter($model, $field, $operator, $value)
    {
        return $this->repository->filter($model, $field, $operator, $value);
    }

    public function orderByField($model, $field, $orderBy)
    {
        return $this->repository->orderByField($model, $field, $orderBy);
    }

    public function paginate($model, $itemPerPage)
    {
        return $this->repository->paginate($model, $itemPerPage);
    }

    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    public function store(Request $request)
    {
        $request->merge(['created_by' => Auth::guard('api')->user()->id]);
        $data = $request->all();

        $groupNotification = config('group_notification');
        $userRoleNotify = array_diff($groupNotification, array(ADMIN_ROLE)); // get user role who will receive mail
        $users = $this->userService->getUserToNotify($userRoleNotify);
        $listEmail = $users->pluck('email')->toArray();

        DB::transaction(function () use ($data, $users, $listEmail) {
            $notification = $this->repository->store($data);
            $notification->users()->attach($users);

            $link = route('web.notification.get', ['id' => $notification->id]);
            Mail::to($listEmail)->send(new SendMailToNotifications($notification->notification_title, $notification->notification_content, $link));
        });
    }

    public function changeStatus($id)
    {
        auth()->user()->getNotification()->detach($id);
        auth()->user()->getNotification()->attach($id, ['status' => READABLE]);
    }
}
