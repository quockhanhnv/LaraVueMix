<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;

class UserService extends BaseService
{
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
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

    public function getUserToNotify($roles)
    {
        return $this->repository->getUserToNotify($roles);
    }
}
