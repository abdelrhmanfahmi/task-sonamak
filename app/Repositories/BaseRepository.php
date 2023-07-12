<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model = null;
    protected $dataSearch = [];

    public function __construct(Model $model , $dataSearch = [])
    {
        $this->model = $model;
        $this->dataSearch = $dataSearch;
    }

    public function find($id): ?Model
    {
        return $this->model->findorfail($id);
    }

    public function store(array $attributes): Model
    {
        return $this->model->create($attributes);

    }

    public function update(array $attributes , $id)
    {
        return $this->model->findorfail($id)->update($attributes);
    }

    public function destroy($id)
    {
        return $this->model->findorfail($id)->delete();
    }

    public function get($filters = false, $paginate = true , $with = [] , $withCount = [] , $count = 15 , $orderBy = 'created_at' , $orderType = 'asc' , $search = false)
    {
        $query = $this->model;

        $orderType = $orderType == '' ? 'asc' : $orderType;

        $query = ($filters == false ? $query : $this->filter($query,$filters));
        $query = ($search == false ? $query : $this->search($query,$search));

        $query = $query->with($with);
        $query = $query->orderBy($orderBy,$orderType);

        $query = ($paginate ? $query->paginate($count) : $query->get());
        return $query;
    }

    public function search($query , $value , $dataSearch = null)
    {
        $columnsToSearch = $dataSearch !== null ? $dataSearch : $this->dataSearch;
        return $query->where(function ($query) use ($columnsToSearch , $value){
            $query = $query->where($columnsToSearch[0] , 'LIKE' , '%' . $value . '%');
            for($index = 1 ; $index < count($columnsToSearch) ; $index++){
                $query = $query->orWhere($columnsToSearch[$index] , 'LIKE' , '%' . $value . '%');
            }
        });
    }

    public function filter($query , $filters)
    {
        $filters = array_filter((array) $filters , function($value){
            return $value !== '*';
        });
        return $query->where($filters);
    }
}
