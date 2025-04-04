<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = 'districts';
    protected $fillable = [
        'code',
        'name',
        'name_en',
        'full_name',
        'full_name_en',
        'code_name',
        'province_code'
    ];
    public function province() {
        return $this->belongsTo(Province::class);
    }
    public function wards() {
        return $this->hasMany(Ward::class);
    }
}
