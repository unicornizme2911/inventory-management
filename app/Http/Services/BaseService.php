<?php

namespace App\Http\Services;

use App\Traits\ResponseAPI;

class BaseService
{
    use ResponseAPI;
    protected $model;
    protected $resource;
    public function __construct($model, $resource)
    {
        $this->model = $model;
        $this->resource = $resource;
    }

    public function getAll()
    {
        return $this->resource::collection($this->model::all());
    }
}
