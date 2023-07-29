<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class AccountVerification extends Component
{
    // Binding Variable
    public $status_filter;

    public function mount() {
        $this->status_filter = 'pending';
    }

    public function render()
    {
        return view('livewire.admin.account-verification')->layout('layouts.admin_app');
    }

    public function set_status_filter($status) {
        $this->status_filter = $status;
        $this->emitTo('users-table', 'setStatusFilter', $status);
    }

}
