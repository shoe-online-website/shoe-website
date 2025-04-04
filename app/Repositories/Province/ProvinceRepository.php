<?php
namespace App\Repositories\Province;

use App\Models\Province;
use App\Repositories\BaseRepository;
use App\Repositories\Province\ProvinceRepositoryInterface;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface{
    public function getModel(){
        return Province::class;
    }
    public function getNameProvince($provinceId) {
        return $this->model->select('full_name')->where('code', $provinceId)->first();
    }
}