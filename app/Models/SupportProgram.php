<?php

namespace App\Models;

use App\Models\Umkm;
use App\Models\SupportProgramMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportProgram extends Model
{
    use HasFactory;

    protected $table = 'support_programs';
    
    protected $fillable = [
        'program_type',
        'name',
        'description',
        'active',
        'quota',
        'open_date',
        'end_date',
    ];

    public function umkm()
    {
        return $this->hasManyThrough(
            Umkm::class,
            SupportProgramMember::class,
            'program_id',
            'id',
            'id',
            'umkm_id',
        );
    }

}
