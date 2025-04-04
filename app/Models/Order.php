<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'name',
        'phone',
        'province',
        'district',
        'ward',
        'email',
        'note',
        'total',
        'discount',
        'coupon_code',
        'order_status_id',
        'payment_complete_date',
    ];
    public function ordersStatus() {
        return $this->belongsTo(OrdersStatus::class);
    }
    public function orderDetail() {
        return $this->hasMany(OrdersDetail::class);
    }
}
