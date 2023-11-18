<?php

namespace App\Http\Livewire\Components;

use App\Models\Umkm;
use Livewire\Component;
use App\Models\UmkmImage;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class MyUmkmCard extends Component
{
    use WithFileUploads;

    // Component Binding Variable
    public $umkm;
    public $index;

    // Binding Variable
    public $edit_state;
    public $name;
    public $sub_district;
    public $recomendation_docs;
    public $images = [];
    public $store_images;

    public $delete_image_ids;

    
    protected $rules = [
        'name' => 'required|string',
        'sub_district' => 'required',
        'recomendation_docs' => 'nullable|image|max:8192',
    ];

    protected $messages = [
        'name.required' => 'Nama UMKM harus diisi',
        'sub_district.required' => 'Kecamatan harus diisi',
        'name.recomendation_docs.image' => 'Surat rekomendasi harus berupa gambar',
        'name.recomendation_docs.max' => 'Ukuran gambar surat rekomendasi tidak boleh lebih dari 2 MB',

    ];

    
    public function updatedImages() {
        $this->validate([
            'images.*' => 'image|max:8192',
        ]);
        $this->store_images = array_merge($this->store_images, $this->images);
        $this->images = [];
    }

    private function reset_state() {
        $this->edit_state = false;
        $this->name = $this->umkm->name;
        $this->sub_district = $this->umkm->sub_district;
        $this->recomendation_docs = '';
        $this->store_images = [];
        $this->delete_image_ids = [];
    }

    public function mount($umkm, $index) {
        $this->umkm = $umkm;
        $this->index = $index;
        $this->reset_state();
    }


    public function render()
    {
        return view('livewire.components.my-umkm-card');
    }

    public function toggle_edit_state() {
        $this->edit_state = !$this->edit_state;
        
        if (!$this->edit_state) {
            $this->reset_state();
        }

    }

    public function delete_stored_image($index) {
        unset($this->store_images[$index]);
    }

    public function set_delete_stored_image($deleteId) {
        array_push($this->delete_image_ids, $deleteId);
    }

    public function save_edit() {
        $this->validate();
        
        $editUmkm = Umkm::find($this->umkm->id);
        if ($editUmkm) {
            $editUmkm->name = $this->name;
            $editUmkm->sub_district = $this->sub_district;
            
            if ($this->recomendation_docs) {
                $oldPath = public_path() . '/storage/' . $editUmkm->recomendation_docs;
                $editUmkm->recomendation_docs = $this->recomendation_docs->store('recomendation_docs');
                
                // Unlink the old files
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Store Umkm Images
            if ($this->store_images) {
                foreach($this->store_images as $image) {
                    $image_path = $image->store('umkm_images');
                    
                    $UmkmImage = new UmkmImage;
                    $UmkmImage->image = $image_path;
                    $UmkmImage->umkm_id = $editUmkm->id;
                    $UmkmImage->save();
                }
            }

            // Delete image in id delete list 
            if (count($this->delete_image_ids)) {
                foreach ($this->delete_image_ids as $delete_id) {
                    $deleteImage = UmkmImage::find($delete_id);
                    if ($deleteImage) {
                        $oldPath = public_path() . '/storage/' . $deleteImage->image;
                        $deleteImage->delete();

                        // Unlink the old files
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                }
            }

            // Set status to pending after update
            if ($editUmkm->status == 'rejected') {
                $editUmkm->status = 'pending';
            }
            
            //  Save
            $editUmkm->save();
            
            return redirect()->route('umkm-registration')->with('message', 'Edit data ' . $this->umkm['type'] . ' berhasil');
            $this->reset_state();
        }
    }

    public function delete_umkm() {
        $deleteUmkm = Umkm::with('umkm_images')->find($this->umkm->id);

        if ($deleteUmkm) {
            // Delete Recomendation Docs FIle
            $recomendation__docs_old_path = public_path() . '/storage/' . $deleteUmkm->recomendation_docs;
            if (file_exists($recomendation__docs_old_path)) {
                unlink($recomendation__docs_old_path);
            }

            // Delete Permission Docs FIle
            if ($deleteUmkm->permission_docs) {
                $permission_docs_old_path = public_path() . '/storage/' . $deleteUmkm->permission_docs;
                if (file_exists($permission_docs_old_path)) {
                    unlink($permission_docs_old_path);
                }
            }

            // Delete Umkm Images Files
            if ($deleteUmkm->umkm_images->count() > 0) {
                foreach ($deleteUmkm->umkm_images as $image) {
                    $oldPath = public_path() . '/storage/' . $image->image;

                    // Unlink the old files
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }

            $deleteUmkm->delete();
            
            return redirect()->route('umkm-registration')->with('message', $this->umkm['type'] . ' berhasil dihapus');
            $this->reset_state();
        }
    }

    public function download_permission_docs() {
        if ($this->umkm->permission_docs) {
            $filename = 'surat_ijin_'. strtolower($this->umkm->type) . '_' . strtolower($this->umkm->name) . '_' . strval(Carbon::now()->timestamp) . '.pdf';
            return Storage::download($this->umkm->permission_docs, $filename);
        } else {
            $msg = ['danger', 'Terjadi kesalahan'];
            $this->dispatchBrowserEvent('display-message', $msg);
        }
    }


}
