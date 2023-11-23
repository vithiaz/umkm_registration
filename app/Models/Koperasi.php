<?php

namespace App\Models;

use App\Models\User;
use App\Models\KoperasiActivationLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Koperasi extends Model
{
    use HasFactory;

    protected $table = 'koperasi';

    protected $fillable = [
        'name',
        'legal_number', // nomor badan hukum
        'legal_date',
        'status',
        'address',
        'village',
        'sub_district',
        'city',
        'owner_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_user', 'id');
    }

    public function activation_log() {
        return $this->hasMany(KoperasiActivationLog::class, 'koperasi_id', 'id');
    }

}
