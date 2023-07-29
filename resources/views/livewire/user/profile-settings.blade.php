@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/profile-page.css') }}">
@endpush

@push('navbar')
    @include('layouts.inc.navbar')
@endpush

<div class="profile-page">
    <div class="container">
        <div class="page-title">
            <h1>Data Identitas</h1>
        </div>
        <div class="page-content-card">
            <div class="card-content">
                <div class="content-wrapper">
                    <div class="row-wrapper">
                        <span class="input-title">NIP</span>
                        <div class="input-items">
                            <span class="input-detail">{{ $User->nip }}</span>
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Nama Lengkap</span>
                        <div class="input-items">
                            <span class="input-detail">{{ $User->full_name }}</span>
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Jenis Kelamin</span>
                        <div class="input-items">
                            <span class="input-detail">{{ $User->gender }}</span>
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Tanggal Lahir</span>
                        <div class="input-items">
                            <span class="input-detail">{{ $User->birth }}</span>
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Alamat</span>
                        <div class="input-items">
                            <span class="input-detail">{{ $User->address }}</span>
                        </div>
                    </div>
                </div>

                <div class="document-wrapper">
                    <div class="picture-wrapper">
                        <div class="image-container">
                            @if ($User->photo)
                                <img src="{{ asset('storage/'.$User->photo) }}" alt="{{ $User->full_name }}_profile">
                            @else
                                <div class="no-image">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="document-details-wrapper">
                        <div class="row-wrapper">
                            <span class="row-title">Kartu Tanda Penduduk (KTP)</span>
                            <div class="row-items">
                                @if ($User->ktp)
                                    <span class="row-detail">diupload</span>
                                    <i class="fa-solid fa-check"></i>
                                @else
                                    <span class="row-detail">perlu upload</span>
                                    <i class="fa-solid fa-xmark"></i>
                                @endif
                            </div>
                        </div>
                        <div class="row-wrapper">
                            <span class="row-title">Kartu Keluarga (KK)</span>
                            <div class="row-items">
                                @if ($User->kk)
                                    <span class="row-detail">diupload</span>
                                    <i class="fa-solid fa-check"></i>
                                @else
                                    <span class="row-detail">perlu upload</span>
                                    <i class="fa-solid fa-xmark"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="button-wrapper">
                    <button class="btn save-button">Simpan</button>
                </div> --}}

            </div>
        </div>
    </div>
</div>
