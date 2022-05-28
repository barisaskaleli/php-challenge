<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Devices extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'devices';

    protected $fillable = [
        'uid',
        'appId',
        'language',
        'operating_system',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
