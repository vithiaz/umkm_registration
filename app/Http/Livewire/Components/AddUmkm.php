<?php

namespace App\Http\Livewire\Components;

use App\Models\Umkm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class AddUmkm extends Component
{
    use WithFileUploads;

    // Binding Variable
    public $name;
    public $type;
    public $recomendation_docs;

    protected $listeners = ['refreshComponent' => '$refresh'];
    
    protected $rules = [
        'name' => 'required|string',
        'type' => 'required',
        'recomendation_docs' => 'required|image|max:2048',
    ];

    public function mount() {
        $this->name = '';
        $this->type = '';
        $this->recomendation_docs = null;
    }
    
    public function render()
    {
        return view('livewire.components.add-umkm');
    }

    public function store_umkm() {
        $this->validate();

        $umkm = new Umkm;
        $umkm->name = $this->name;
        $umkm->type = $this->type;
        $umkm->status = 'pending';
        $umkm->owner_user = Auth::user()->id;

        // Store Recimendation Docs
        $recomendation_docs_path = $this->recomendation_docs->store('recomendation_docs');
        $umkm->recomendation_docs = $recomendation_docs_path;

        $umkm->save();
        
        $msg = ['success' => $this->type . ' dalam pengajuan'];
        $this->dispatchBrowserEvent('display-message', $msg);

        $this->name = '';
        $this->type = '';
        $this->recomendation_docs = null;
        $this->emit('refreshComponent');
    }

}
