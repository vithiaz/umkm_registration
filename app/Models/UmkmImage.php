<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmImage extends Model
{
    use HasFactory;

    protected $table = 'umkm_images';

    protected $fillable = [
        'image',
        'umkm_id',
    ];

}
