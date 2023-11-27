<?php

namespace App\Models;

use App\Models\Umkm;
use App\Models\User;
use App\Models\SolarRecomendation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolarRecomendationRequest extends Model
{
    use HasFactory;
    
    protected $table = 'solar_recomendation_requests';

    protected $fillable = [
        'status',
        'message',
        'umkm_id',
    ];

    public function solar_recomendation()
    {
        return $this->hasOne(SolarRecomendation::class, 'request_id', 'id');
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'id');
    }

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Umkm::class,
            'id',
            'id',
            'umkm_id',
            'owner_user',
        );
    }

}
