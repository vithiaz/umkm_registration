<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolarRecomendation extends Model
{
    use HasFactory;

    protected $table = 'solar_recomendations';

    protected $fillable = [
        'document_number',
        'registration_date',
        'expired_date',
        'solar_recomendation_docs',
        'request_id',
    ];


}
