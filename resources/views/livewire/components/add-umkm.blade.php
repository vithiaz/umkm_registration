<form wire:submit.prevent='store_umkm' class="page-card col-wrap">
    <div class="row-wrapper">
        <span class="input-title">Nama</span>
        <div class="input-items">
            <input wire:model='name' type="text" class="main-form-input" placeholder="Nama Koperasi / UMKM">
            @error('name')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row-wrapper">
        <span class="input-title">Jenis</span>
        <div class="input-items">
            <select wire:model='type' class="form-select" aria-label="Default select example">
                <option selected value="" hidden>Pilih Koperasi / UMKM</option>
                <option value="UMKM">UMKM</option>
                <option value="Koperasi">Koperasi</option>
            </select>
            @error('type')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row-wrapper">
        <span class="input-title">Surat Pengantar</span>
        <div class="input-items">
            <input wire:model='recomendation_docs' type="file" class="form-control file" accept="image/*" >
            @error('recomendation_docs')
                <small class="error">{{ $message }}</small>
            @else
                <small>* surat pengantar dapat diambil di kantor kelurahan atau dapat digantikan dengan surat domisili</small>
            @enderror
        </div>
    </div>
    <div class="row-wrapper picture-form">
        <span class="input-title">Tambahkan Gambar</span>
        <input wire:model='images' type="file" id="umkm-picture-input" style="display: none" multiple>
        <div class="input-items image-wrapper">
            <div class="input-button-container">
                <button type="button" id="umkm-picture-input-button" class="btn submit-button ico hovered">
                    <i class="fa-solid fa-plus"></i>
                    <span>upload</span>
                </button>
                
                @error('images')
                    <span class="error">{{ $message }}</span>
                @else
                    @if ($this->store_images)
                        <span class="info">{{ count($this->store_images) }} gambar diupload</span>
                    @endif
                @enderror
                
            </div>
            @if ($this->store_images)
                @foreach ($this->store_images as $index => $image)
                    <div wire:click='delete_stored_image({{ $index }})' class="image-container hovered">
                        <div class="hovered-overlay">
                            <i class="fa-solid fa-trash"></i>
                        </div>
                        <img src="{{ $image->temporaryUrl() }}" alt="upload_umkm_image_{{ $index }}">
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="button-wrapper">
        <button type="submit" class="btn submit-button">Ajukan Pendaftaran</button>
    </div>
</form>

@push('script')
<script>

    $('#umkm-picture-input-button').click(function () {
        $('#umkm-picture-input').click()
    })

</script>    
@endpush