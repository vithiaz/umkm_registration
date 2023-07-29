<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Umkm;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'is_admin',
        'active_status',
        'nip',
        'full_name',
        'gender',
        'birth',
        'address',
        'ktp',
        'kk',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function umkm()
    {
        return $this->hasMany(Umkm::class, 'owner_user', 'id');
    }

    public function active_umkm()
    {
        return $this->hasMany(Umkm::class, 'owner_user', 'id')->where('status', '=', 'verified');
    }

}
