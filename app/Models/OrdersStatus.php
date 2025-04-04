<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersStatus extends Model
{
    use HasFactory;
    protected $table = 'orders_status';
    protected $fillable = [
        'name',
        'color',
        'is_success',
    ];
    public function orders() {
        $this->hasMany(Order::class);
    }
}
