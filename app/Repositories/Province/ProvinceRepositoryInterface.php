<?php 
namespace App\Repositories\Province;

use App\Repositories\RepositoryInterface;
interface ProvinceRepositoryInterface extends RepositoryInterface{
    public function getNameProvince($provinceId);
}
