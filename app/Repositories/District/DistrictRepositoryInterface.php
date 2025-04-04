<?php 
namespace App\Repositories\District;

use App\Repositories\RepositoryInterface;
interface DistrictRepositoryInterface extends RepositoryInterface{
    public function getDistrictByProvince($provinceId);
    public function getNameDistrict($districtId);
}
