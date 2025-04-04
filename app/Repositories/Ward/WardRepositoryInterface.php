<?php 
namespace App\Repositories\Ward;

use App\Repositories\RepositoryInterface;
interface WardRepositoryInterface extends RepositoryInterface{
    public function getWardsByDistrict($districtId);
    public function getNameWard($wardId);
}
