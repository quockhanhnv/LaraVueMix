<?php

namespace App\Repositories;
use Prophecy\Exception\Doubler\ClassNotFoundException;

abstract class BaseRepository
{
    public $model;

    public function __construct()
    {
        $model = $this->model();
        if (!class_exists($model)) {
            throw new ClassNotFoundException('Class not found', $model);
        }

        $this->model = new $model();
    }

    public abstract function model();
}
