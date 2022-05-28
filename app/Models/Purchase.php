<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';

    protected $fillable = [
        'receipt_hash',
        'expired_at',
        'device_id'
    ];

    protected $dates = [
        'expired_at'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'device_id'
    ];

    public function device()
    {
        return $this->belongsTo(Devices::class, 'device_id', 'id');
    }
}
