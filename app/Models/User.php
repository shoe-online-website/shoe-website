<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = "users";
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'content',
        'ward',
        'district',
        'province',
        'address',
        'phone'
    ];
}
