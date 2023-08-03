<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmActivationLog extends Model
{
    use HasFactory;

    protected $table = 'umkm_activation_logs';

    protected $fillable = [
        'status',
        'message',
        'umkm_id',
    ];

}
