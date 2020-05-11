<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function withRelation($relation);

    public function filter($models, $field, $operator, $value);

    public function orderByField($model, $field, $orderBy);

    public function paginate($models, $itemPerPage);

    public function findById($id);

    public function store($data);

    public function getUserToNotify($roles);
}
