<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivationLog extends Model
{
    use HasFactory;
    
    protected $table = 'activation_logs';

    protected $fillable = [
        'status',
        'message',
        'user_id',
    ];

}
