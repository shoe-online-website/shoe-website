<?php
namespace App\Repositories\District;

use App\Models\District;
use App\Repositories\BaseRepository;
use App\Repositories\District\DistrictRepositoryInterface;

class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface{
    public function getModel(){
        return District::class;
    }
    public function getDistrictByProvince($provinceId) {
        return $this->model->where('province_code', $provinceId)->get();
    }
    public function getNameDistrict($districtId) {
        return $this->model->select('full_name')->where('code', $districtId)->first();
    }
}