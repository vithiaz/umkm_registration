<?php

namespace App\Http\Livewire;

use App\Models\Umkm;
use Livewire\Component;
use App\Models\Koperasi;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use App\Models\UserNotification;
use App\Models\UmkmActivationLog;
use App\Models\KoperasiActivationLog;

class KoperasiVerification extends Component
{
    use WithFileUploads;

    // Binding Variable
    public $status_filter;

    public $verifyKoperasi;
    public $reject_state;
    public $reject_message;

    public $acc_state;
    public $permission_docs;

    
    protected $listeners = [
        'setVerifyData' => 'setVerifyData'
    ];

    protected $rules = [
        'reject_message' => 'required|string'
    ];

    protected $messages = [
        'reject_message.required' => 'Pesan penolakan harus diisi',
    ];

    public function setVerifyData($userID) {
        $this->reset_state();
        $verifyKoperasi = Koperasi::with(['user', 'activation_log'])->find($userID);
        
        if ($verifyKoperasi) {
            $this->verifyKoperasi = $verifyKoperasi;
            $this->dispatchBrowserEvent('scroll-up');
        }
    }

    private function reset_state() {
        $this->verifyKoperasi = null;
        $this->reject_state = false;
        $this->reject_message = '';
        $this->acc_state = false;
        $this->permission_docs = null;

        $this->emitTo('koperasi-table', 'refreshTable');
    }

    public function mount() {
        $this->status_filter = 'pending';
        
        $this->reset_state();
    }

    public function render()
    {
        return view('livewire.koperasi-verification')->layout('layouts.admin_app');
    }

    public function set_status_filter($status) {
        $this->reset_state();
        
        $this->status_filter = $status;
        $this->emitTo('koperasi-table', 'setStatusFilter', $status);
    }

    public function set_reject_state($status) {
        if ($status == true) {
            $this->reject_state = true;
        } else {
            $this->reject_state = false;
            $this->reject_message = '';
        }
    }
    
    public function set_acc_state($status) {
        $this->dispatchBrowserEvent('show-verify-modal');
        // if ($status == true) {
        //     $this->acc_state = true;
        // } else {
        //     $this->acc_state = false;
        //     $this->permission_docs = null;
        // }
    }

    public function reject_request () {
        $this->validate();

        if ($this->verifyKoperasi) {
            $this->verifyKoperasi->status = 'rejected';
            $this->verifyKoperasi->save();

            // Create Activation Log
            $activationLog = new KoperasiActivationLog;
            $activationLog->status = 'rejected';
            $activationLog->message = $this->reject_message;
            $activationLog->koperasi_id = $this->verifyKoperasi->id;
            $activationLog->save();

            // Create Notification
            $notificationBody = "
                <p>Pengajuan Aktivasi Koperasi dengan nama ". $this->verifyKoperasi->name ." ditolak</p>
                <p>". $this->reject_message ."</p>
            ";
            $notification = new UserNotification;
            $notification->title = 'Penolakan Aktivasi Koperasi';
            $notification->body = $notificationBody;
            $notification->is_read = false;
            $notification->user_id = $this->verifyKoperasi->user->id;
            $notification->save();

            $msg = ['info' => 'Pengajuan Ditolak'];
            $this->dispatchBrowserEvent('display-message', $msg);

            $this->reset_state();
        }
    }

    public function acc_request() {
        // $this->validate([
        //     'permission_docs' => 'required|mimes:pdf',
        // ],
        // [
        //     'permission_docs.required' => 'Surat Ijin harus di upload',
        //     'permission_docs.file' => 'Surat Ijin harus dalam bentuk .pdf',
        //     'permission_docs.mimes' => 'Surat Ijin harus dalam bentuk .pdf',
        // ]);

        if ($this->verifyKoperasi) {
            $this->verifyKoperasi->status = 'verified';
            // $this->verifyKoperasi->permission_docs = $this->permission_docs->store('permission_docs');
            $this->verifyKoperasi->save();

            // Create Activation Log
            $activationLog = new KoperasiActivationLog;
            $activationLog->status = 'acc';
            $activationLog->message = $this->reject_message;
            $activationLog->koperasi_id = $this->verifyKoperasi->id;
            $activationLog->save();

            // Create Notification
            $notificationBody = "
                <p>Pengajuan Aktivasi Koperasi dengan nama ". $this->verifyKoperasi->name ." diterima.</p>
            ";
            $notification = new UserNotification;
            $notification->title = 'Pengajuan aktivasi Koperasi diterima';
            $notification->body = $notificationBody;
            $notification->is_read = false;
            $notification->user_id = $this->verifyKoperasi->user->id;
            $notification->save();

            $msg = ['success' => 'Pengajuan Diterima'];
            $this->dispatchBrowserEvent('display-message', $msg);

            $this->reset_state();
        }


    }

    public function format_datetime($datetime, $format) {
        return Carbon::parse($datetime)->format($format);
    }


}
