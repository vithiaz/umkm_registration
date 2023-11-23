<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoperasiActivationLog extends Model
{
    use HasFactory;

    protected $table = 'koperasi_activation_logs';

    protected $fillable = [
        'status',
        'message',
        'koperasi_id',
    ];
}
