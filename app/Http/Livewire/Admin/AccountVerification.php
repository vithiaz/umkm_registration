<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\ActivationLog;

class AccountVerification extends Component
{
    // Binding Variable
    public $status_filter;

    public $verifyAccount;

    public $reject_message;
    public $reject_state;

    
    protected $listeners = [
        'setVerifyData' => 'setVerifyData'
    ];
    
    
    protected $rules = [
        'reject_message' => 'required|string'
    ];

    public function mount() {
        $this->status_filter = 'pending';
        $this->reject_state = false;
        $this->reject_message = '';

        $this->verifyAccount = null;
    }

    public function render()
    {
        return view('livewire.admin.account-verification')->layout('layouts.admin_app');
    }

    public function set_status_filter($status) {
        $this->status_filter = $status;
        $this->emitTo('users-table', 'setStatusFilter', $status);
    }


    public function setVerifyData($userID) {
        $verifyUser = User::find($userID);
        if ($verifyUser) {
            $this->verifyAccount = $verifyUser;
            $this->dispatchBrowserEvent('scroll-up');
        }
    }



    public function set_reject_state($status) {
        if ($status == 1) {
            $this->reject_state = true;
        } else {
            $this->reject_state = false;
            $this->reject_message = '';
        }
    }

    public function reject_request() {
        $this->validate();
        
        $reject_user_id = $this->verifyAccount['id'];
        
        $activationLog = new ActivationLog;
        $activationLog->status = 'rejected';
        $activationLog->message = $this->reject_message;
        $activationLog->user_id = $reject_user_id;

        if ($activationLog->save()) {
            $msg = ['info' => 'Verifikasi Ditolak'];
        } else {
            $msg = ['danger' => 'Terjadi Kesalahan'];
        }

        $this->dispatchBrowserEvent('display-message', $msg);

        $this->reject_state = false;
        $this->reject_message = '';

        $this->verifyAccount = null;
    }

    public function verify_request() {
        if ($this->verifyAccount) {
            $this->verifyAccount->active_status = 'active';
            $this->verifyAccount->save();

            $activationLog = new ActivationLog;
            $activationLog->status = 'acc';
            $activationLog->message = 'Berkas diterima';
            $activationLog->user_id = $this->verifyAccount->id;
            $activationLog->save();

            $msg = ['success' => 'Pengajuan Diverifikasi'];
            $this->dispatchBrowserEvent('display-message', $msg);

            $this->reject_state = false;
            $this->reject_message = '';
    
            $this->verifyAccount = null;    
        }
    }

}
