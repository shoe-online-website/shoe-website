<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersDetail extends Model
{
    use HasFactory;
    protected $table = 'orders_detail';
    protected $fillable = [
        'order_id',
        'product_id',
        'size_number',
        'price',
        'quantity'
    ];
    public function orders() {
        return $this->belongsTo(Order::class);
    }
}
