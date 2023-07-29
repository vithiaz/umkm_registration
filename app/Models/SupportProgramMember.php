<?php

namespace App\Models;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportProgramMember extends Model
{
    use HasFactory;

    protected $table = 'support_program_members';

    protected $fillable = [
        'status',
        'program_id',
        'umkm_id',
    ];

    public function umkm()
    {
        return $this->hasOne(Umkm::class, 'id', 'umkm_id');
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
