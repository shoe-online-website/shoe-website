<?php
namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface{
    public function getModel(){
        return User::class;
    }
    public function getUsers($isAdmin = 0) {
        return $this->model->where('is_admin', $isAdmin)->latest('created_at')->get();
    }
    public function search($keyword) {
        return 
        $this->model
        ->where('is_admin', 1)
        ->when(!empty($keyword), function ($query) use ($keyword) {
            return $query->where('name', 'like', '%'.$keyword.'%')->orwhere('email', 'like', '%'.$keyword.'%');
        })
        ->get();
    }
}