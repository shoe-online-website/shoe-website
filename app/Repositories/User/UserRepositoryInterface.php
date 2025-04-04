<?php 
namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;
interface UserRepositoryInterface extends RepositoryInterface{
    public function getUsers($isAdmin = 0);
    public function search($keyword);
}
