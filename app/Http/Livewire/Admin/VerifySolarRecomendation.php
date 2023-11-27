<?php

namespace App\Http\Livewire\Admin;

use App\Models\Umkm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use App\Models\UserNotification;
use App\Models\SolarRecomendationRequest;
use App\Models\SolarRecomendation as SolarRecomendationModel;

class VerifySolarRecomendation extends Component
{
    use WithFileUploads;

    // Binding Variable
    public $status_filter;

    public $verifyRequest;
    public $historyRequest;
    public $reject_state;
    public $reject_message;
    
    public $acc_state;
    public $recomendation_docs;
    public $document_number;
    public $registration_date;
    public $expired_date;


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
        $verifyRequest = SolarRecomendationRequest::with([
            'solar_recomendation',
            'umkm',
            'user',
        ])->find($userID);
        
        if ($verifyRequest) {
            $this->verifyRequest = $verifyRequest;
            $this->historyRequest = SolarRecomendationRequest::with([
                'solar_recomendation',
            ])->where([
                ['umkm_id', '=', $verifyRequest->umkm_id],
            ])->get();
            $this->dispatchBrowserEvent('scroll-up');
        }
    }

    public function reset_state() {
        $this->verifyRequest = null;
        $this->reject_message = '';
        $this->reject_state = false;
        $this->acc_state = false;
        $this->recomendation_docs = null;

        $this->document_number = '';
        $this->registration_date = '';
        $this->expired_date = '';

        $this->emitTo('admin.solar-recomendation-request-table', 'refreshTable');
    }

    public function mount() {
        $this->status_filter = 'pending';
        $this->reset_state();
    }

    public function render()
    {
        return view('livewire.admin.verify-solar-recomendation')->layout('layouts.admin_app');
    }

    public function set_status_filter($status) {
        $this->reset_state();
        
        $this->status_filter = $status;
        $this->emitTo('admin.solar-recomendation-request-table', 'setStatusFilter', $status);
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
            $this->recomendation_docs = null;
        }
    }

    public function reject_request () {
        $this->validate();

        if ($this->verifyRequest) {
            $this->verifyRequest->status = 'rejected';
            $this->verifyRequest->message = 'pengajuan surat rekomendasi ditolak, ' . $this->reject_message;
            $this->verifyRequest->save();

            // Create Notification
            $notificationBody = "
                <p>Pengajuan Surat Rekomendasi Pengambilan Solar anda ditolak.
                <p>". $this->reject_message ."</p>
            ";
            $notification = new UserNotification;
            $notification->title = 'Pengajuan aktivasi Surat Rekomendasi Pengambilan Solar ditolak';
            $notification->body = $notificationBody;
            $notification->is_read = false;
            $notification->user_id = $this->verifyRequest->user->id;
            $notification->save();

            $msg = ['info' => 'Pengajuan Ditolak'];
            $this->dispatchBrowserEvent('display-message', $msg);

            $this->reset_state();
        }
    }

    public function acc_request() {
        $this->validate([
            'recomendation_docs' => 'required|mimes:pdf',
            'document_number' => 'required',
            'registration_date' => 'required',
            'expired_date' => 'required',
        ],
        [
            'recomendation_docs.required' => 'Surat Rekomendasi harus di upload',
            'recomendation_docs.file' => 'Surat Rekomendasi harus dalam bentuk .pdf',
            'recomendation_docs.mimes' => 'Surat Rekomendasi harus dalam bentuk .pdf',
            'document_number.required' => 'nomor surat harus diisi',
            'registration_date.required' => 'tanggal registrasi harus diisi',
            'expired_date.required' => 'tanggal berakhir harus diisi',
        ]);

        if ($this->verifyRequest) {
            $this->verifyRequest->status = 'done';
            $this->verifyRequest->message = 'pengajuan surat rekomendasi diterima';
            $this->verifyRequest->save();

            // Create solar_recomendations table
            $solar_recom = new SolarRecomendationModel;
            $solar_recom->document_number = $this->document_number;
            $solar_recom->registration_date = $this->registration_date;
            $solar_recom->expired_date = $this->expired_date;
            $solar_recom->request_id = $this->verifyRequest->id;
            $solar_recom->solar_recomendation_docs = $this->recomendation_docs->store('solar_recomendation_docs');
            $solar_recom->save();

            // Create Notification
            $notificationBody = "
                <p>Pengajuan Surat Rekomendasi Pengambilan Solar anda telah diterima
                <p>Silahkan mendownload Surat Rekomendasi Pengambilan Solar yang anda daftarkan melalui menu Pengajuan Rekomendasi Solar, atau klik <a href=\"/solar-recomendations\">disini</a>.</p>
                <p>Terima kasih telah mendaftar</p>
            ";
            $notification = new UserNotification;
            $notification->title = 'Pengajuan aktivasi Surat Rekomendasi Pengambilan Solar diterima';
            $notification->body = $notificationBody;
            $notification->is_read = false;
            $notification->user_id = $this->verifyRequest->user->id;
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
