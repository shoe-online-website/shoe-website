<?php
namespace App\Repositories\Ward;

use App\Models\Ward;
use App\Repositories\BaseRepository;
use App\Repositories\Ward\WardRepositoryInterface;

class WardRepository extends BaseRepository implements WardRepositoryInterface{
    public function getModel(){
        return Ward::class;
    }
    public function getWardsByDistrict($districtId) {
        return $this->model->where('district_code', $districtId)->get();
    }
    public function getNameWard($wardId) {
        return $this->model->select('full_name')->where('code', $wardId)->first();
    }
}