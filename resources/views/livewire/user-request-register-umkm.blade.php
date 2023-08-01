<form wire:submit.prevent='register_program' class="page-card col-wrap">
    <span class="card-title">{{ $program->name }}</span>

    <div class="row-wrapper">
        <span class="row-title">Tipe Program</span>
        <span class="row-body">Bantuan {{ $program->program_type }}</span>
    </div>
    <div class="row-wrapper">
        <span class="row-title">Pendaftaran</span>
        <span class="row-body"><i>{{ $program->open_date }}</i> <strong>-</strong> <i>{{ $program->end_date }}</i></span>
    </div>
    <div class="row-wrapper">
        <span class="row-title">Kuota</span>
        <span class="row-body">{{ $program->umkm->count() }} / {!! $program->quota || ($program->quota > 0) ? $program->quota : '&#8734;'   !!}</span>
    </div>

    <span class="card-seperator-text">Deskripsi</span>
    <p class="content">
        {{ $program->description }}
    </p>
    @if ($this->allowed)
        <div class="registration-wrapper">
            <div class="title-box">
                <span class="card-title">Pendaftaran</span>
            </div>
            <span class="info">Koperasi dan UMKM yang dapat didaftarkan adalah yang sudah terdaftar dan diverifikasi</span>
            <div class="row-wrapper">
                <span class="input-title">Koperasi / UMKM</span>
                <div class="input-items">
                    <select wire:model='selectedUmkmId' class="form-select" aria-label="Default select example">
                        <option selected value="" hidden>Pilih Koperasi / UMKM</option>
                        @if ($program->program_type == 'UMKM')
                            @foreach ($activeUmkm as $umkm)
                                <option value="{{ $umkm->id }}">{{ $umkm->name }}</option>
                            @endforeach                                    
                        @else
                            @foreach ($activeKoperasi as $umkm)
                                <option value="{{ $umkm->id }}">{{ $umkm->name }}</option>
                            @endforeach                                    
                        @endif
                    </select>
                    @error('selectedUmkmId')
                        <small class="error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="button-wrapper">
                <button class="btn submit-button">Ajukan Pendaftaran</button>
            </div>
        </div>
    @endif
</form>