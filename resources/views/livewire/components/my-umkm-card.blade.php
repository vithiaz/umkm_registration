<div class="page-card row-wrap">
    <div class="col-wrap">
        <div class="row-wrapper">
            <span class="input-title">Nama</span>
            <div class="input-items">
                @if ($this->edit_state)
                    <input wire:model='name' type="text" class="main-form-input" placeholder="Nama Koperasi / UMKM">
                    @error('name')
                        <small class="error">{{ $message }}</small>
                    @enderror
                @else
                    <span class="label">{{ $umkm->name }}</span>
                @endif
            </div>
        </div>
        <div class="row-wrapper">
            <span class="input-title">Kecamatan</span>
            <div class="input-items">
                @if ($this->edit_state)
                    <select wire:model='sub_district' class="form-select" aria-label="Default select example">
                        <option selected value="" hidden>Pilih Kecamatan</option>
                        <option value="Tomohon Barat">Tomohon Barat</option>
                        <option value="Tomohon Selatan">Tomohon Selatan</option>
                        <option value="Tomohon Tengah">Tomohon Tengah</option>
                        <option value="Tomohon Timur">Tomohon Timur</option>
                        <option value="Tomohon Utara">Tomohon Utara</option>
                    </select>
                    @error('sub_district')
                        <small class="error">{{ $message }}</small>
                    @enderror                    
                @else
                    <span class="label">{{ $umkm->sub_district }}</span>
                @endif
            </div>
        </div>
        @if ($this->edit_state)
            <div class="row-wrapper">
                <span class="input-title">Surat Pengantar</span>
                <div class="input-items">
                    <input wire:model='recomendation_docs' type="file" class="form-control file" accept="image/*" >
                    @error('recomendation_docs')
                        <small class="error">{{ $message }}</small>
                    @else
                        <small>* ubah surat pengantar</small>
                    @enderror
                </div>
            </div>
        @else
            {{-- <div class="row-wrapper">
                <span class="input-title">Jenis</span>
                <div class="input-items">
                    <span class="">{{ $umkm->type }}</span>
                </div>
            </div> --}}
            <div class="row-wrapper">
                <span class="input-title">Status</span>
                <div class="input-items ico-wrap">
                    @if ($umkm->status == 'pending')
                        <i class="info fa-solid fa-clock-rotate-left"></i>
                        <span class="">Dalam proses pengajuan</span>
                    @endif
                    @if ($umkm->status == 'verified')
                        <i class="active fa-solid fa-square-check"></i>
                        <span class="">Aktif</span>
                    @endif
                    @if ($umkm->status == 'rejected')
                        <i class="reject fa-solid fa-square-xmark"></i>
                        <span class="">Pengajuan ditolak</span>                            
                    @endif
                </div>
            </div>
            @if ($umkm->status == 'rejected' && $umkm->activation_log->count() > 0)
                @if ($umkm->activation_log->sortByDesc('created_at')->first()->status == 'rejected')
                    <div class="row-wrapper">
                        <span class="input-title">Pesan Penolakan</span>
                        <div class="input-items">
                            <span class="" style="font-weight: 600; color: red">{{ $umkm->activation_log->sortByDesc('created_at')->first()->message }}</span>
                        </div>
                    </div>
                @endif
            @endif
        @endif

        <div class="row-wrapper @if ($this->edit_state) top-align @endif">
            <div class="input-title">Gambar</div>
            <div class="input-items row-button">
                @if ($this->edit_state)
                    <input wire:model='images' id="umkm-image-input-{{ $index }}" type="file" style="display: none" multiple>
                    <button onclick="umkmInputImageTrigger({{ $index }})" type="button" class="btn add-button ico">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah</span>
                    </button>
                @endif
                @if ($umkm->umkm_images->count() > 0)
                    <button onclick="toggleViewImages({{ $index }})" id="view-images-btn-{{ $index }}" type="button" class="btn submit-button ico hovered @if($this->edit_state) active @endif">
                        <i class="fa-solid fa-eye"></i>
                        <span>Lihat</span>
                    </button>
                @else
                    <span>Tidak ada gambar</span>
                @endif
            </div>
        </div>
        
        

    </div>
    
    @if ($umkm->umkm_images->count() > 0)
        <div id="view-images-{{ $index }}" class="image-wrapper @if($this->edit_state) active @endif">
            @foreach ($umkm->umkm_images as $img_index => $image)
                <div onclick="setDeleteStoredImage({{ $image->id }})" class="image-container @if($this->edit_state) hovered @endif @if(in_array($image->id, $this->delete_image_ids)) gone @endif">
                    @if ($this->edit_state)
                        <div class="hovered-overlay">
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    @endif
                    <img wire:loading.lazy src="{{ asset('storage/'.$image->image) }}" alt="{{ $umkm->name }}_image_{{ $img_index }}">
                </div>            
            @endforeach

            @foreach ($this->store_images as $img_index => $image)
                <div wire:click='delete_stored_image({{ $img_index }})' class="image-container hovered">
                    <div class="hovered-overlay">
                        <i class="fa-solid fa-trash"></i>
                    </div>

                    <img wire:loading.lazy src="{{ $image->temporaryUrl() }}" alt="{{ $umkm->name }}_upload_umkm_image_{{ $index }}">
                </div>
            @endforeach

        </div>
    @endif

    <div id="button-container-{{ $index }}" class="card-button-container @if($this->edit_state) full-basis @endif">
        @if ($umkm->status == "verified" && $umkm->permission_docs)
            <button wire:click='download_permission_docs' class="btn download-button ico">
                <i class="fa-regular fa-file"></i>
                <span>Download Surat Ijin</span>
            </button>
        @else

            @if ($this->edit_state)
                <button wire:click='delete_umkm' type="button" class="btn delete-button ico" style="width: 120px; justify-content: space-between; flex-direction: row-reverse; margin-left: 20px">
                    <i class="fa-solid fa-trash"></i>
                    <span>Hapus</span>
                </button>                
                <button wire:click='toggle_edit_state' type="button" class="btn abort-button ico" style="width: 120px; justify-content: space-between; flex-direction: row-reverse; margin-left: 20px">
                    <i class="fa-solid fa-ban"></i>
                    <span>Batalkan</span>
                </button>                
                <button wire:click.prevent='save_edit' type="button" class="btn save-button ico" style="width: 120px; justify-content: space-between; flex-direction: row-reverse; margin-left: 20px">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan</span>
                </button>                
            @else
                <button wire:click='toggle_edit_state' type="button" class="btn edit-button ico hovered">
                    <i class="fa-solid fa-pen"></i>
                    <span>Ubah Data</span>
                </button>                                
            @endif

        @endif
    </div>
</div>


@push('script')
<script>

    function setDeleteStoredImage(deleteId) {
        if (@this.edit_state) {
            @this.set_delete_stored_image(deleteId)
        }
    }
    
</script>
@endpush