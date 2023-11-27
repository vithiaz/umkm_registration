@push('stylesheet')
<link rel="stylesheet" href="{{ asset('css/user-recomendation-solar-page.css') }}">
@endpush

@push('navbar')
@include('layouts.inc.navbar')
@endpush

<div class="recomendation-solar-page">
    <div class="container">
        <div class="title-container">
            <div class="page-title">
                <h1>SURAT REKOMENDASI PENGAMBILAN SOLAR</h1>
            </div>
            <div class="select-umkm-card">
                <span class="input-title">UMKM</span>
                <div class="input-items">
                    <select wire:model='selected_umkm' class="form-select" aria-label="Default select example">
                        <option selected="" value="" hidden="">Pilih UMKM</option>
                        @foreach ($active_umkm as $umkm)
                            <option value="{{ $umkm->id }}">{{ $umkm->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <section class="recomendation-card-container">
            <div class="section-title-wrapper">
                <span class="section-title">Daftar Surat Rekomendasi</span>
                <span wire:click='request_recomendation' class="add-button">+ Buat Pengajuan</span>
            </div>
            @forelse ($this->recomendations->sortBy('updated_at', SORT_REGULAR, true) as $recomendation)
                <div class="solar-recomendation-card page-card">
                    @if ($recomendation->status == 'pending')
                        <div class="row-wrapper">
                            <span class="label">Tanggal Pengajuan</span>
                            <span class="values">{{ $recomendation->created_at }}</span>
                        </div>
                        <div class="row-wrapper">
                            <span class="label">Status</span>
                            <div class="values-wrapper ico-wrap">
                                <i class="info fa-solid fa-clock-rotate-left"></i>
                                <span class="">Dalam proses pengajuan</span>
                            </div>
                        </div>
                        <div class="row-wrapper">
                            <span class="label"></span>
                            <span wire:click='abort_request_recomendation({{ $recomendation->id }})' class="values abort">Batalkan Pengajuan</span>
                        </div>
                    @else
                        <div class="row-wrapper">
                            <span class="label">Status</span>
                            <div class="values-wrapper">
                                @if ($recomendation->status == 'done')
                                    <i class="active fa-solid fa-square-check"></i>
                                    <span class="">Selesai</span>
                                @endif
                                @if ($recomendation->status == 'rejected')
                                    <i class="reject fa-solid fa-square-xmark"></i>
                                    <span class="">Pengajuan ditolak</span>                            
                                @endif
                            </div>
                        </div>
                        <div class="row-wrapper">
                            <span class="label">Nomor Surat</span>
                            <span class="values">No. 2023/XX/YYY/SOL103</span>
                        </div>
                        <div class="row-wrapper">
                            <span class="label">Masa Berlaku</span>
                            <div class="values-wrapper">
                                <span class="values bold">11/27/2023</span>
                                <span>sampai</span>
                                <span class="values bold">12/30/2023</span>
                            </div>
                        </div>
                        @if ($recomendation->status == 'done')
                            <div class="row-wrapper">
                                <span class="label">Surat Rekomendasi</span>
                                <span wire:click='download_docs({{ $recomendation->id }})' class="values download">Download Surat Rekomendasi</span>
                            </div>
                        @endif
                    @endif
                </div>
                
            @empty
                <div class="page-card col-wrap">
                    <div class="empty-container">
                        <span>Tidak ada surat rekomendasi ...</span>
                    </div>
                </div>
            @endforelse
        </section>

        {{-- @forelse ($SupportProgram as $program)
        <livewire:user-request-register-umkm :program='$program' :activeUmkm='$ActiveUmkm'
            :activeKoperasi='$ActiveKoperasi' :allowed='$AccountActivated' />
        @empty
        <div class="page-card col-wrap">
            <div class="empty-container">
                <span>Program bantuan UMKM belum tersedia ...</span>
            </div>
        </div>
        @endforelse --}}




    </div>
</div>