<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected Model $model;
    private array $relations;

    public function __construct(Model $model, array $relations = [])
    {
        $this->model = $model;
        $this->relations = $relations;
    }

    public function getAll()
    {
        return $this->model->withTrashed()->get();
    }

    public function getOne(int $id)
    {
        $query = $this->model;
        if (!empty($this->relations))
        {
            $query = $query->with($this->relations);
        }
        return $query->withTrashed()->find($id);
    }

    public function saveModel(Model $model)
    {
        $model->save();
        return $model;
    }

    public function deleteModel(Model $model)
    {
        $model->delete();
        return $model;
    }


}
