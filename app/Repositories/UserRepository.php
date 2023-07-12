<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{
    protected $dataSearch = [];
    private $user = null;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->dataSearch = ['name'];
        parent::__construct($user , $this->dataSearch);
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

}
