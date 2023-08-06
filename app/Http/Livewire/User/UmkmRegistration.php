<?php

namespace App\Http\Livewire\User;

use App\Models\Umkm;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UmkmRegistration extends Component
{
    // Model Variable
    public $User;
    public $Umkms;
    
    public function mount() {
        $this->User = Auth::user();
        $this->Umkms = Umkm::with(['umkm_images', 'activation_log'])->where('owner_user', '=', $this->User->id)->get();
    }

    public function render()
    {
        return view('livewire.user.umkm-registration')->layout('layouts.row-app');
    }
}
