<?php

namespace App\Http\Livewire\User;

use App\Models\Umkm;
use Livewire\Component;
use App\Models\Koperasi;
use Illuminate\Support\Facades\Auth;

class KoperasiRegistration extends Component
{
    // Model Variable
    public $User;
    public $Koperasi;
    
    public function mount() {
        $this->User = Auth::user();
        $this->Koperasi = Koperasi::with('activation_log')->where('owner_user', '=', $this->User->id)->get();
    }
    
    public function render()
    {
        return view('livewire.user.koperasi-registration')->layout('layouts.row-app');
    }
}
