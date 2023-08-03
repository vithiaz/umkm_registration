<?php

namespace App\Models;

use App\Models\User;
use App\Models\UmkmImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Umkm extends Model
{
    use HasFactory;
    
    protected $table = 'umkm';

    protected $fillable = [
        "name",
        "type",
        "recomendation_docs",
        "status",
        "permission_docs",
        "owner_user",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_user', 'id');
    }

    public function umkm_images() {
        return $this->hasMany(UmkmImage::class, 'umkm_id', 'id');
    }

}
