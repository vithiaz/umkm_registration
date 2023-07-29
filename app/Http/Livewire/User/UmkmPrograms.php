<?php

namespace App\Http\Livewire\User;

use App\Models\Umkm;
use App\Models\User;
use Livewire\Component;
use App\Models\SupportProgram;
use Illuminate\Support\Facades\Auth;

class UmkmPrograms extends Component
{
    // Model Variable
    public $SupportProgram;
    public $ActiveKoperasiUmkm;
    public $ActiveUmkm;
    public $ActiveKoperasi;

    public function mount() {
        $this->SupportProgram = SupportProgram::with('umkm')->where('active', '=' , true)->get();
        $this->ActiveKoperasiUmkm = User::with('active_umkm')->find(Auth::user()->id)->active_umkm;
        $this->ActiveUmkm = $this->ActiveKoperasiUmkm->where('type', '=', 'UMKM');
        $this->ActiveKoperasi = $this->ActiveKoperasiUmkm->where('type', '=', 'Koperasi');
    }
    
    public function render()
    {
        return view('livewire.user.umkm-programs')->layout('layouts.row-app');
    }

}
