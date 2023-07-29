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
    <div class="button-wrapper">
        <button class="btn submit-button">Ajukan Pendaftaran</button>
    </div>
</form>