<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function model()
    {
        return User::class;
    }

    public function withRelation($relation)
    {
        return $this->model->with($relation);
    }

    public function filter($model, $field, $operator, $value)
    {
        return $model->where($field, $operator, $value);
    }

    public function orderByField($model, $field, $orderBy)
    {
        return $model->orderBy($field, $orderBy);
    }

    public function paginate($model, $itemPerPage)
    {
        return $model->paginate($itemPerPage);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function store($data)
    {
        return $this->model->insert($data);
    }

    public function getUserToNotify($roles)
    {
        return $this->model->whereIn('role',$roles)->get();
    }
}
