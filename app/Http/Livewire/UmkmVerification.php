<?php

namespace App\Http\Livewire;

use App\Models\Umkm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use App\Models\UserNotification;
use App\Models\UmkmActivationLog;

class UmkmVerification extends Component
{
    use WithFileUploads;

    // Binding Variable
    public $status_filter;

    public $verifyUmkm;
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
        $verifyUmkm = Umkm::with(['user', 'umkm_images', 'activation_log'])->find($userID);
        
        if ($verifyUmkm) {
            $this->verifyUmkm = $verifyUmkm;
            $this->dispatchBrowserEvent('scroll-up');
        }
    }

    private function reset_state() {
        $this->verifyUmkm = null;
        $this->reject_message = '';
        $this->reject_state = false;
        $this->acc_state = false;
        $this->permission_docs = null;

        $this->emitTo('umkms-table', 'refreshTable');
    }

    public function mount() {
        $this->status_filter = 'pending';
        
        $this->reset_state();
    }

    public function render()
    {
        return view('livewire.umkm-verification')->layout('layouts.admin_app');
    }

    public function set_status_filter($status) {
        $this->reset_state();
        
        $this->status_filter = $status;
        $this->emitTo('umkms-table', 'setStatusFilter', $status);
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
        if ($status == true) {
            $this->acc_state = true;
        } else {
            $this->acc_state = false;
            $this->permission_docs = null;
        }
    }

    public function reject_request() {
        $this->validate();

        if ($this->verifyUmkm) {
            $this->verifyUmkm->status = 'rejected';
            $this->verifyUmkm->updated_at = Carbon::now();
            $this->verifyUmkm->save();

            // Create Activation Log
            $activationLog = new UmkmActivationLog;
            $activationLog->status = 'rejected';
            $activationLog->message = $this->reject_message;
            $activationLog->umkm_id = $this->verifyUmkm->id;
            $activationLog->created_at = Carbon::now();
            $activationLog->updated_at = Carbon::now();
            $activationLog->save();

            // Create Notification
            $notificationBody = "
                <p>Pengajuan Aktivasi " . $this->verifyUmkm->type ." dengan nama ". $this->verifyUmkm->name ." ditolak</p>
                <p>". $this->reject_message ."</p>
            ";
            $notification = new UserNotification;
            $notification->title = 'Penolakan Aktivasi '.$this->verifyUmkm->type;
            $notification->body = $notificationBody;
            $notification->is_read = false;
            $notification->user_id = $this->verifyUmkm->user->id;
            $notification->save();

            $msg = ['info' => 'Pengajuan Ditolak'];
            $this->dispatchBrowserEvent('display-message', $msg);

            $this->reset_state();
        }
    }

    public function confirm_acc_request() {
        $this->dispatchBrowserEvent('show-verify-modal');
    }
    
    public function acc_request() {
        $this->validate([
            'permission_docs' => 'required|mimes:pdf',
        ],
        [
            'permission_docs.required' => 'Surat Ijin harus di upload',
            'permission_docs.file' => 'Surat Ijin harus dalam bentuk .pdf',
            'permission_docs.mimes' => 'Surat Ijin harus dalam bentuk .pdf',
        ]);

        if ($this->verifyUmkm) {
            $this->verifyUmkm->status = 'verified';
            $this->verifyUmkm->permission_docs = $this->permission_docs->store('permission_docs');
            $this->verifyUmkm->updated_at = Carbon::now();
            $this->verifyUmkm->save();

            // Create Activation Log
            $activationLog = new UmkmActivationLog;
            $activationLog->status = 'acc';
            $activationLog->message = 'Pengajuan aktivasi ' . $this->verifyUmkm->type . ' diterima';
            $activationLog->umkm_id = $this->verifyUmkm->id;
            $activationLog->created_at = Carbon::now();
            $activationLog->updated_at = Carbon::now();
            $activationLog->save();

            // Create Notification
            $notificationBody = "
                <p>Pengajuan Aktivasi " . $this->verifyUmkm->type ." dengan nama ". $this->verifyUmkm->name ." diterima.</p>
                <p>Silahkan mendownload Surat Ijin Koperasi / UMKM yang anda daftarkan melalui menu Pendaftaran Koperasi dan UMKM, atau klik <a href=\"/registration\">disini</a>.</p>
                <p>". $this->verifyUmkm->type ." yang sudah aktif dapat anda ajukan ke program bantuan yang tersedia dan dapat anda lihat pada menu Pengajuan Bantuan atau klik <a href=\"/programs\">disini</a>.</p>
                <p>Terima kasih telah mendaftar</p>
            ";
            $notification = new UserNotification;
            $notification->title = 'Pengajuan aktivasi '.$this->verifyUmkm->type . ' diterima';
            $notification->body = $notificationBody;
            $notification->is_read = false;
            $notification->user_id = $this->verifyUmkm->user->id;
            $notification->save();

            $msg = ['success' => 'Pengajuan Diterima'];
            $this->dispatchBrowserEvent('display-message', $msg);
            $this->dispatchBrowserEvent('show-success-modal');

            $this->reset_state();
        }


    }

    public function format_datetime($datetime, $format) {
        return Carbon::parse($datetime)->format($format);
    }


    


}
