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
                    <span class="label">{{ $koperasi->name }}</span>
                @endif
            </div>
        </div>
        <div class="row-wrapper">
            <span class="input-title">No. Badan Hukum</span>
            <div class="input-items">
                @if ($this->edit_state)
                    <input wire:model='legal_number' type="text" class="main-form-input" placeholder="Nomor Badan Hukum">
                @error('legal_number')
                    <small class="error">{{ $message }}</small>
                @enderror
                @else
                    <span class="label">{{ $koperasi->legal_number }}</span>
                @endif
            </div>
        </div>
        <div class="row-wrapper">
            <span class="input-title">Tanggal Badan Hhukum</span>
            <div class="input-items">
                @if ($this->edit_state)
                    <input wire:model='legal_date' type="date" class="main-form-input" placeholder="Tanggal Badan Hukum">
                @error('legal_date')
                    <small class="error">{{ $message }}</small>
                @enderror
                @else
                    <span class="label">{{ $koperasi->legal_date }}</span>
                @endif
            </div>
        </div>
        <div class="row-wrapper">
            <span class="input-title">Alamat Lengkap</span>
            <div class="input-items">
                @if ($this->edit_state)
                    <textarea wire:model='address' rows="3" class="main-form-input" placeholder="Alamat Lengkap"></textarea>
                @error('address')
                    <small class="error">{{ $message }}</small>
                @enderror
                @else
                    <span class="label">{{ $koperasi->address }}</span>
                @endif
            </div>
        </div>
        <div class="row-wrapper">
            <span class="input-title">Kecamatan</span>
            <div class="input-items">
                @if ($this->edit_state)
                    <select wire:model='sub_district' class="form-select" aria-label="Default select example">
                        <option selected value="" hidden>Pilih Kecamatan</option>
                        @foreach (array_keys($this->tomohon_data) as $subDist)
                            <option value="{{ $subDist }}">{{ $subDist }}</option>
                        @endforeach
                    </select>
                @error('sub_district')
                    <small class="error">{{ $message }}</small>
                @enderror
                @else
                    <span class="label">{{ $koperasi->sub_district }}</span>
                @endif
            </div>
        </div>
        <div class="row-wrapper">
            <span class="input-title">Desa / Kelurahan</span>
            <div class="input-items">
                @if ($this->edit_state)
                    <select wire:model='village' class="form-select" aria-label="Default select example">
                        <option selected value="" hidden>Pilih Desa / Kelurahan</option>
                        @if ($this->sub_district)
                            @foreach ($this->tomohon_data[$this->sub_district] as $village)
                                <option value="{{ $village }}">{{ $village }}</option>
                            @endforeach
                        @endif
                    </select>
                @error('village')
                    <small class="error">{{ $message }}</small>
                @enderror
                @else
                    <span class="label">{{ $koperasi->village }}</span>
                @endif
            </div>
        </div>

        <div class="row-wrapper">
            <span class="input-title">Status</span>
            <div class="input-items ico-wrap">
                @if ($koperasi->status == 'pending')
                <i class="info fa-solid fa-clock-rotate-left"></i>
                <span class="">Dalam proses pengajuan</span>
                @endif
                @if ($koperasi->status == 'verified')
                <i class="active fa-solid fa-square-check"></i>
                <span class="">Aktif</span>
                @endif
                @if ($koperasi->status == 'rejected')
                <i class="reject fa-solid fa-square-xmark"></i>
                <span class="">Pengajuan ditolak</span>
                @endif
            </div>
        </div>

        @if ($koperasi->status == 'rejected' && $koperasi->activation_log->count() > 0)
            @if ($koperasi->activation_log->sortByDesc('created_at')->first()->status == 'rejected')
                <div class="row-wrapper">
                    <span class="input-title">Pesan Penolakan</span>
                    <div class="input-items">
                        <span class="" style="font-weight: 600; color: red">{{
                            $koperasi->activation_log->sortByDesc('created_at')->first()->message }}</span>
                    </div>
                </div>
            @endif
        @endif
        {{-- @endif --}}

        
    </div>

    <div id="button-container-{{ $index }}" class="card-button-container @if($this->edit_state) full-basis @endif">
        {{-- @if ($koperasi->status == "verified" && $koperasi->permission_docs)
        <button wire:click='download_permission_docs' class="btn download-button ico">
            <i class="fa-regular fa-file"></i>
            <span>Download Surat Ijin</span>
        </button>
        @else --}}

        @if ($koperasi->status != "verified")
            @if ($this->edit_state)
            <button wire:click='delete' type="button" class="btn delete-button ico"
                style="width: 120px; justify-content: space-between; flex-direction: row-reverse; margin-left: 20px">
                <i class="fa-solid fa-trash"></i>
                <span>Hapus</span>
            </button>
            <button wire:click='toggle_edit_state' type="button" class="btn abort-button ico"
                style="width: 120px; justify-content: space-between; flex-direction: row-reverse; margin-left: 20px">
                <i class="fa-solid fa-ban"></i>
                <span>Batalkan</span>
            </button>
            <button wire:click.prevent='save_edit' type="button" class="btn save-button ico"
                style="width: 120px; justify-content: space-between; flex-direction: row-reverse; margin-left: 20px">
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