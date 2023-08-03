@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/registration.css') }}">
@endpush

@push('navbar')
    @include('layouts.inc.navbar')
@endpush

<div class="registration">
    <div class="container">
        <div class="page-title">
            <span><span class="lighter">P</span>ENDAFTARAN AKUN</span>
        </div>
        <form wire:submit.prevent='register' class="registration-content-body" enctype="multipart/form-data">
            <div class="content">
                <span class="content-title">IDENTITAS</span>
                <div class="content-row-wrapper">
                    <div class="main">
                        <div class="row-wrapper">
                            <span class="input-title">NIK</span>
                            <div class="input-items">
                                <input wire:model='nip' type="number" class="main-form-input" placeholder="NIK">
                                @error('nip')
                                    <small class="error">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row-wrapper">
                            <span class="input-title">Nama Lengkap</span>
                            <div class="input-items">
                                <input wire:model='full_name' type="text" class="main-form-input" placeholder="Nama Lengkap">
                                @error('full_name')
                                    <small class="error">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row-wrapper">
                            <span class="input-title">Tanggal Lahir</span>
                            <div class="input-items">
                                <input wire:model='birth' type="date" class="main-form-input">
                                @error('birth')
                                    <small class="error">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row-wrapper">
                            <span class="input-title">Jenis Kelamin</span>
                            <div class="input-items">
                                <select wire:model='gender' class="form-select" aria-label="Pilih jenis kelamin">
                                    <option selected value="" hidden>Pilih jenis kelamin</option>
                                    <option value="laki-laki">Laki - laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                                @error('gender')
                                    <small class="error">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row-wrapper top">
                            <span class="input-title">Alamat</span>
                            <div class="input-items">
                                <textarea wire:model='address' type="text" class="main-form-input" placeholder="Alamat lengkap"></textarea>
                                @error('address')
                                    <small class="error">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="secondary">
                        <p>Pastikan data identitas sesuai dengan yang tertera di Kartu Tanda Penduduk (KTP)</p>
                    </div>
                </div>
            </div>

            <div class="content">
                <span class="content-title">UPLOAD DOKUMEN</span>
                <div class="content-wrapper">
                    <div class="row-wrapper">
                        <span class="input-title">Kartu Tanda Penduduk</span>
                        <div class="input-items">
                            <input wire:model='ktp' type="file" class="form-control file" accept="image/*">
                            @error('ktp')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Kartu Keluarga</span>
                        <div class="input-items">
                            <input wire:model='kk' type="file" class="form-control file" accept="image/*">
                            @error('kk')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Pas Foto</span>
                        <div class="input-items">
                            <input wire:model='photo' type="file" class="form-control file" accept="image/*">
                            @error('photo')
                                <small class="error">{{ $message }}</small>
                            @else
                                <small>* pas foto pemilik usaha, diupload dengan ukuran 3x4 (cm)</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-wrapper">
                <button type="submit" class="btn submit-button">Daftarkan Akun</button>
            </div>

        </form>
    </div>
</div>
