<?php

namespace App\Http\Livewire\User;

use App\Models\Umkm;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\SolarRecomendationRequest;

class SolarRecomendation extends Component
{
    // Model Variable
    public $active_umkm;
    public $recomendations;

    // Binding Variable
    public $selected_umkm;

    public function mount() {
        $this->active_umkm = Umkm::where([
            ['owner_user', '=', Auth::user()->id],
            ['status', '=', 'verified'],
        ])->get();

        $this->selected_umkm = '';
    }

    public function render()
    {
        $this->recomendations = SolarRecomendationRequest::with([
            'solar_recomendation',
            'umkm',
        ])->where('umkm_id', '=', $this->selected_umkm)->get();
        return view('livewire.user.solar-recomendation')->layout('layouts.row-app');
    }

    public function request_recomendation() {
        $recomReq = new SolarRecomendationRequest;
        $recomReq->status = 'pending';
        $recomReq->message = 'permintaan pengajuan surat rekomendasi pengambilan solar';
        $recomReq->umkm_id = $this->selected_umkm;
        $recomReq->save();

        $msg = ['success' => 'Permintaan Dikirim'];
        $this->dispatchBrowserEvent('display-message', $msg);
    }

    public function abort_request_recomendation($recomId) {
        $recomAbort = SolarRecomendationRequest::find($recomId);
        if ($recomAbort) {
            $recomAbort->delete();
            $msg = ['info' => 'Permintaan Dibatalkan'];
            $this->dispatchBrowserEvent('display-message', $msg);
        }
    }

    public function download_docs($recomId) {
        $recomReq = SolarRecomendationRequest::with([
            'solar_recomendation',
            'umkm',
        ])->find($recomId);
        
        if ($recomReq->solar_recomendation && $recomReq->solar_recomendation->solar_recomendation_docs) {
            $filename = 'surat_rekomendasi_pengambilan_solar_'. strtolower($recomReq->umkm->name) . '_' . strval(Carbon::now()->timestamp) . '.pdf';
            return Storage::download($recomReq->solar_recomendation->solar_recomendation_docs, $filename);
        } else {
            $msg = ['danger', 'Terjadi kesalahan'];
            $this->dispatchBrowserEvent('display-message', $msg);
        }
    }

}
