<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $table = "sizes";
    protected $fillable = [
        'size_number',
    ];
    public function products() {
        return $this->belongsToMany(Product::class, 'products_sizes')->withPivot(['quantity', 'updated_at'])->withTimestamps();
    }
}
