<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    // Binding Variable
    public $Notifications;

    public function mount() {
        $this->Notifications = UserNotification::where('user_id', '=', Auth::user()->id)->get();
    }

    public function render()
    {
        return view('livewire.notifications')->layout('layouts.row-app');
    }
}
