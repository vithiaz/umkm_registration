<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SupportProgram;
use App\Models\SupportProgramMember;

class UserRequestRegisterUmkm extends Component
{
    // Model Binding Variable
    public $program;
    public $activeUmkm;
    public $activeKoperasi;
    public $allowed;

    // Binding Variable
    public $selectedUmkmId;

    // 
    public $registered_umkm_ids;

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected $rules = [
        'selectedUmkmId' => 'required',
    ];

    protected $messages = [
        'selectedUmkmId.required' => 'Tidak ada Koperasi / UMKM dipilih'
    ];

    public function mount($program, $activeUmkm, $activeKoperasi, $allowed){
        $this->program = $program;
        $this->getUmkmLists($activeUmkm, $activeKoperasi);
        $this->allowed = $allowed;
    }

    public function render()
    {
        return view('livewire.user-request-register-umkm');
    }

    private function getUmkmLists($activeUmkm, $activeKoperasi) {
        $this->selectedUmkmId = '';
        $this->registered_umkm_ids = [];
        $registered_umkm = $this->program->umkm ? $this->program->umkm : [];
        foreach ($registered_umkm as $umkm) {
            array_push($this->registered_umkm_ids, $umkm->id);
        }
        $this->activeUmkm = $activeUmkm->whereNotIn('id', $this->registered_umkm_ids);
        $this->activeKoperasi = $activeKoperasi->whereNotIn('id', $this->registered_umkm_ids);
    }

    public function register_program() {
        $this->validate();
        $SupportProgramMember = new SupportProgramMember;
        $SupportProgramMember->status = 'pending';
        $SupportProgramMember->program_id = $this->program->id;
        $SupportProgramMember->umkm_id = $this->selectedUmkmId;

        if ($SupportProgramMember->save()) {
            $msg = ['success' => 'Permintaan pendaftaran dikirm'];
        } else {
            $msg = ['danger' => 'Terjadi kesalahan'];
        }
        $this->dispatchBrowserEvent('display-message', $msg);
        $this->getUmkmLists($this->activeUmkm, $this->activeKoperasi);
    }


}
