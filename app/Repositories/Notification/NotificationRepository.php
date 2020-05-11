<?php

namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Repositories\BaseRepository;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{

    public function model()
    {
        return Notification::class;
    }

    public function withRelation($relation)
    {
        return $this->model->with($relation);
    }

    public function filter($models, $field, $operator, $value)
    {
        return $models->where($field, $operator, $value);
    }

    public function orderByField($model, $field, $orderBy)
    {
        return $model->orderBy($field, $orderBy);
    }

    public function paginate($models, $itemPerPage)
    {
        return $models->paginate($itemPerPage);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }
}
