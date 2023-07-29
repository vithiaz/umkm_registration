<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UmkmVerification extends Component
{
    // Binding Variable
    public $status_filter;

    public function mount() {
        $this->status_filter = 'pending';
    }

    public function render()
    {
        return view('livewire.umkm-verification')->layout('layouts.admin_app');
    }

    public function set_status_filter($status) {
        $this->status_filter = $status;
        $this->emitTo('umkms-table', 'setStatusFilter', $status);
    }

    


}
