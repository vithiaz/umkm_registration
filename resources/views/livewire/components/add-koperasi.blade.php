<form wire:submit.prevent='store' class="page-card col-wrap">
    <div class="row-wrapper">
        <span class="input-title">Nama</span>
        <div class="input-items">
            <input wire:model='name' type="text" class="main-form-input" placeholder="Nama Koperasi">
            @error('name')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row-wrapper">
        <span class="input-title">No. Badan Hukum</span>
        <div class="input-items">
            <input wire:model='legal_number' type="text" class="main-form-input" placeholder="Nomor Badan Hukum">
            @error('legal_number')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row-wrapper">
        <span class="input-title">Tanggal Badan Hukum</span>
        <div class="input-items">
            <input wire:model='legal_date' type="date" class="main-form-input" placeholder="Tanggal Badan Hukum">
            @error('legal_date')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row-wrapper">
        <span class="input-title">Alamat Lengkap</span>
        <div class="input-items">
            <textarea wire:model='address' class="main-form-input" rows="2" placeholder="alamat lengkap"></textarea>
            @error('address')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row-wrapper">
        <span class="input-title">Kecamatan</span>
        <div class="input-items">
            <select wire:model='sub_district' class="form-select" aria-label="Default select example">
                <option selected value="" hidden>Pilih Kecamatan</option>
                @foreach (array_keys($this->tomohon_data) as $subDist)
                    <option :value="$subDist">{{ $subDist }}</option>
                @endforeach
            </select>
            @error('sub_district')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row-wrapper">
        <span class="input-title">Desa / Kelurahan</span>
        <div class="input-items">
            <select id="village-input" class="form-select" aria-label="Default select example">
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
        </div>
    </div>
    <div class="button-wrapper">
        <button type="submit" class="btn submit-button">Daftarkan</button>
    </div>
</form>

@push('script')
<script>

    $('#umkm-picture-input-button').click(function () {
        $('#umkm-picture-input').click()
    })

    $('#village-input').on('change', function() {
        @this.set_village(this.value)
    });


</script>    
@endpush