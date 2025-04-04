<?php
namespace App\Repositories\Coupon;

use App\Models\Coupon;
use App\Repositories\BaseRepository;
use App\Repositories\Coupon\CouponRepositoryInterface;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface{
    public function getModel(){
        return Coupon::class;
    }
    public function getCouponByCode($code) {
        return $this->model->where('code', $code)->first();
    }
}