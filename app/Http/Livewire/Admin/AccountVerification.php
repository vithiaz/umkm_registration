<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\ActivationLog;
use Illuminate\Support\Carbon;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;

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

    protected $messages = [
        'reject_message.required' => 'Pesan penolakan harus diisi',
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
        $this->reject_state = false;
        $this->reject_message = '';
        $this->verifyAccount = null;

        $this->status_filter = $status;
        $this->emitTo('users-table', 'setStatusFilter', $status);
    }


    public function setVerifyData($userID) {
        $verifyUser = User::with('activation_log')->find($userID);
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
        
        $UserEdit = User::find($reject_user_id);
        $UserEdit->active_status = 'rejected';
        $UserEdit->save();
        
        $activationLog = new ActivationLog;
        $activationLog->status = 'rejected';
        $activationLog->message = $this->reject_message;
        $activationLog->user_id = $reject_user_id;

        // Create Notification
        $notificationBody = "
            <p>Pengajuan Aktivasi akun anda ditolak</p>
            <p>". $this->reject_message ."</p>
        ";
        $notification = new UserNotification;
        $notification->title = 'Penolakan Aktivasi Akun';
        $notification->body = $notificationBody;
        $notification->is_read = false;
        $notification->user_id = $this->verifyAccount->id;
        $notification->save();

        if ($activationLog->save()) {
            $msg = ['info' => 'Verifikasi Ditolak'];
        } else {
            $msg = ['danger' => 'Terjadi Kesalahan'];
        }

        $this->dispatchBrowserEvent('display-message', $msg);

        $this->reject_state = false;
        $this->reject_message = '';

        $this->verifyAccount = null;
        $this->status_filter = 'rejected';
        $this->emitTo('users-table', 'setStatusFilter', $this->status_filter);
    }

    public function confirm_verify_request() {
        $this->dispatchBrowserEvent('show-verify-modal');
    }
    
    public function verify_request() {
        if ($this->verifyAccount) {
            $this->verifyAccount->active_status = 'active';
            $this->verifyAccount->save();

            $activationLog = new ActivationLog;
            $activationLog->status = 'acc';
            $activationLog->message = 'Berkas diterima dan akun diverifikasi';
            $activationLog->user_id = $this->verifyAccount->id;
            $activationLog->save();

            // Create Notification
            $notificationBody = "
                <p>Pengajuan Aktivasi akun anda diterima, anda sekarang dapat melakukan registrasi Koperasi atau UMKM.</p>
                <p>Silahkan mengakses menu Pendaftaran untuk registrasi Koperasi atau UMKM anda, atau klik <a href=\"/registration\">disini</a>.</p>
                <p>Terima kasih telah mendaftar</p>
            ";
            $notification = new UserNotification;
            $notification->title = 'Pengajuan Aktivasi Akun Diterima';
            $notification->body = $notificationBody;
            $notification->is_read = false;
            $notification->user_id = $this->verifyAccount->id;
            $notification->save();

            $msg = ['success' => 'Pengajuan Diverifikasi'];
            $this->dispatchBrowserEvent('display-message', $msg);
            $this->dispatchBrowserEvent('show-success-modal');
            $this->emitTo('users-table', 'refreshTable');

            $this->reject_state = false;
            $this->reject_message = '';
    
            $this->verifyAccount = null;    
        }
    }

    public function format_datetime($datetime, $format) {
        return Carbon::parse($datetime)->format($format);
    }

}
