<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\SupportProgram;

class UmkmProgramDetails extends Component
{
    // Route Binding Variable
    public $program_id;
    public $status_filter;

    // Model Variable
    public $SupportProgram;

    public function mount($program_id) {
        $this->status_filter = 'pending';
        $this->program_id = $program_id;
        
        $this->SupportProgram = SupportProgram::with('umkm')->find($this->program_id);
        if (!$this->SupportProgram) {
            return redirect()->route('admin.umkm-programs');
        }

    }

    public function render()
    {
        return view('livewire.admin.umkm-program-details')->layout('layouts.admin_app');
    }

    public function set_status_filter($status) {
        $this->status_filter = $status;
        $this->emitTo('support-program-members-table', 'setStatusFilter', $status);
    }

}
