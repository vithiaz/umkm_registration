@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/umkm-registration.css') }}">
@endpush

@push('navbar')
    @include('layouts.inc.navbar')
@endpush


<div class="umkm-registration">
    <div class="container">

        <div class="user-info-card">
            <div class="image-wrapper">
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
            <div class="name-wrapper">
                <span class="nip">NIK. {{ $User->nip }}</span>
                <span class="name">{{ $User->full_name }}</span>
            </div>
            <div class="document-wrapper">
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

        <div class="page-title">
            <h1>PENDAFTARAN KOPERASI DAN UMKM</h1>
        </div>

        <livewire:components.add-umkm />

        <div class="page-title secondary">
            <h1>Koperasi / UMKM Saya</h1>
        </div>

        @foreach ($Umkms as $index => $umkm)
            <div class="page-card row-wrap">
                <div class="col-wrap">
                    <div class="row-wrapper">
                        <span class="input-title">Nama</span>
                        <div class="input-items">
                            <span class="label">{{ $umkm->name }}</span>
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Jenis</span>
                        <div class="input-items">
                            <span class="">{{ $umkm->type }}</span>
                        </div>
                    </div>
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
                    @if ($umkm->umkm_images->count() > 0)
                        <div class="row-wrapper">
                            <div class="input-title">Lihat Gambar</div>
                            <div class="input-items row-button">
                                <button onclick="toggleViewImages({{ $index }})" id="view-images-btn-{{ $index }}" type="button" class="btn submit-button ico hovered">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>Lihat</span>
                                </button>
                            </div>
                        </div>    
                    @endif
                </div>
                @if ($umkm->umkm_images->count() > 0)
                    <div id="view-images-{{ $index }}" class="image-wrapper">
                        @foreach ($umkm->umkm_images as $img_index => $image)
                            <div class="image-container">
                                <img wire:loading.lazy src="{{ asset('storage/'.$image->image) }}" alt="{{ $umkm->name }}_image_{{ $img_index }}">
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- @if ($umkm->permission_docs) --}}
                    <div class="download-container">
                        <button class="btn download-button"><i class="fa-solid fa-download"></i> Download Surat Ijin</button>
                    </div>
                {{-- @endif --}}
            </div>            
        @endforeach

        {{-- <div class="page-card col-wrap">
            <div class="empty-container">
                <span>Belum ada UMKM yang terdaftar...</span>
            </div>
        </div> --}}


    </div>
</div>

@push('script')
<script>

    function toggleViewImages(elemId) {
        $('#view-images-btn-'+elemId).toggleClass('active')
        $('#view-images-'+elemId).toggleClass('active')
    }
    
</script>
@endpush