<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileSettings extends Component
{
    // Model Variable
    public $User;

    // Binding Variable
    
    public function mount() {
        $this->User = Auth::user();
    }


    public function render()
    {
        return view('livewire.user.profile-settings')->layout('layouts.user_app');
        // return view('livewire.user.profile-settings')->layout('layouts.row-app');
    }
}
