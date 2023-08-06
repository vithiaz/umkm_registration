<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    // Binding Variable
    private $NotificationQuery;
    public $Notifications;
    public $unread_Notifications;

    public $notif_load_count;
    public $notif_load_step = 6;

    public function mount() {
        $this->notif_load_count = $this->notif_load_step;
        $this->NotificationQuery = UserNotification::where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        $this->Notifications = $this->NotificationQuery->where('is_read', '=', true);
        $this->unread_Notifications = $this->NotificationQuery->where('is_read', '=', false);
        
        foreach ($this->unread_Notifications as $notif) {
            $notif->is_read = true;
            $notif->save();
        }

    }

    public function render()
    {
        $notifications = $this->Notifications->take($this->notif_load_count);
        return view('livewire.notifications', [
            'notifications' => $notifications,
        ])->layout('layouts.row-app');
    }

    public function load_more() {
        $this->notif_load_count += $this->notif_load_step;
        $this->dispatchBrowserEvent('refreshScripts');
    }

}
