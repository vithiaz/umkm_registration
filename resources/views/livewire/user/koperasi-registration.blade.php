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
            <h1>PENDAFTARAN Koperasi</h1>
        </div>

        <livewire:components.add-koperasi />

        <div class="page-title secondary">
            <h1>Koperasi Saya</h1>
        </div>

        @forelse ($Koperasi as $index => $kop)
            <livewire:components.my-koperasi-card :koperasi='$kop' :index='$index' />
        @empty
            <div class="page-card col-wrap">
                <div class="empty-container">
                    <span>Belum ada Koperasi yang terdaftar...</span>
                </div>
            </div>
        @endforelse



    </div>
</div>

@push('script')
<script>

    // MyUmkmCard script
    function toggleViewImages(elemId) {
        $('#view-images-btn-'+elemId).toggleClass('active')
        $('#view-images-'+elemId).toggleClass('active')
        $('#button-container-'+elemId).toggleClass('full-basis')
    }

    function umkmInputImageTrigger(elemId) {
        $('#umkm-image-input-'+elemId).click()
    }
    
</script>
@endpush