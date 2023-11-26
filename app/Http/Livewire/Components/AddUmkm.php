<?php

namespace App\Http\Livewire\Components;

use App\Models\Umkm;
use Livewire\Component;
use App\Models\UmkmImage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class AddUmkm extends Component
{
    use WithFileUploads;

    // Binding Variable
    public $name;
    public $sub_district;
    public $recomendation_docs;
    public $images = [];
    public $store_images;

    protected $listeners = ['refreshComponent' => '$refresh'];
    
    protected $rules = [
        'name' => 'required|string',
        'sub_district' => 'required',
        'recomendation_docs' => 'required|image|max:8192',
    ];

    public function updatedImages() {
        $this->validate([
            'images.*' => 'image|max:8192',
        ]);
        $this->store_images = array_merge($this->store_images, $this->images);
        $this->images = [];
    }

    public function mount() {
        $this->name = '';
        $this->sub_district = '';
        $this->recomendation_docs = null;
        $this->store_images = [];
    }
    
    public function render()
    {
        return view('livewire.components.add-umkm');
    }

    public function store_umkm() {        
        $this->validate();

        $umkm = new Umkm;
        $umkm->name = $this->name;
        $umkm->type = 'UMKM';
        $umkm->sub_district = $this->sub_district;
        $umkm->status = 'pending';
        $umkm->owner_user = Auth::user()->id;

        // Store Recimendation Docs
        $recomendation_docs_path = $this->recomendation_docs->store('recomendation_docs');
        $umkm->recomendation_docs = $recomendation_docs_path;

        $umkm->save();

        // Store Umkm Images
        if ($this->store_images) {
            foreach($this->store_images as $image) {
                $image_path = $image->store('umkm_images');
                
                $UmkmImage = new UmkmImage;
                $UmkmImage->image = $image_path;
                $UmkmImage->umkm_id = $umkm->id;
                $UmkmImage->save();
            }
        }

        return redirect()->route('umkm-registration')->with('message', 'UMKM dalam pengajuan');
        
        $this->name = '';
        $this->sub_district = '';
        $this->recomendation_docs = null;
        $this->images = [];
        $this->store_images = [];
    }

    public function delete_stored_image($index) {
        unset($this->store_images[$index]);
    }

}
