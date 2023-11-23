<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\SupportProgram;

class UmkmPrograms extends Component
{
    // Binding Variable
    public $name;
    public $description;
    public $program_type;
    public $quota;
    public $open_date;
    public $end_date;
    // Table Filter
    public $active_status;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'required|string',
        'quota' => 'nullable|numeric',
        'open_date' => 'nullable|date',
        'end_date' => 'nullable|date',
    ];

    public function mount() {
        $this->name = '';
        $this->description = '';
        $this->program_type = 'UMKM';
        $this->quota = '';
        $this->open_date = '';
        $this->end_date = '';
        $this->active_status = true;
    }

    public function render()
    {
        return view('livewire.admin.umkm-programs')->layout('layouts.admin_app');
    }

    public function set_status_filter($status) {
        $this->active_status = $status;
        $this->emitTo('admin.support-program-table', 'setStatusFilter', $status);
    }

    public function store_program() {
        $this->validate();
        
        $Program = new SupportProgram;
        $Program->program_type = 'UMKM';
        $Program->name = $this->name;
        $Program->description = $this->description;
        $Program->active = true;
        $Program->quota = $this->quota ? $this->quota : null;
        $Program->open_date = $this->open_date;
        $Program->end_date = $this->end_date;

        $this->name = '';
        $this->description = '';
        $this->program_type = 'UMKM';
        $this->quota = '';
        $this->open_date = '';
        $this->end_date = '';

        if ($Program->save()) {
            $msg = ['success' => 'Program berhasil tersimpan'];
        } else {
            $msg = ['danger' => 'Terjadi kesalahan'];
        }
        $this->dispatchBrowserEvent('display-message', $msg);
        $this->emitTo('admin.support-program-table', 'refreshTable');

    }


}
