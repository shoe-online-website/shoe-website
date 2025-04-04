<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        'name',
        'slug',
        'code',
        'price',
        'discount',
        'sale_price',
        'image',
        'gallery',
        'description',
        'category_id',
        'status',
    ];
    public function sizes() {
        return $this->belongsToMany(Size::class, 'products_sizes')->withPivot('quantity');
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
