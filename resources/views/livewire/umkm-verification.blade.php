@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/umkm-verification-page.css') }}">
@endpush

<div class="content-body umkm-verification">
    <div class="container">
        <div id="verify-page-title" class="page-title">
            <h1>Verifikasi Pendaftaran UMKM</h1>
        </div>

        <div class="page-content-card page-verify-card @if($this->verifyUmkm) active @endif">
            <div class="info-wrapper">
                <span class="content-title">Informasi Pemilik</span>
                <div class="owner-info-wrapper">
                    <div class="info-wrapper">
                        <div class="row-wrapper">
                            <span class="input-title">Nama</span>
                            <div class="input-items">{{ $this->verifyUmkm ? $this->verifyUmkm->user->full_name : '' }}</div>
                        </div>
                        <div class="row-wrapper">
                            <span class="input-title">Alamat</span>
                            <div class="input-items">{{ $this->verifyUmkm ? $this->verifyUmkm->user->address : '' }}</div>
                        </div>                    
                        <div class="row-wrapper">
                            <span class="input-title">Kontak</span>
                            <div class="input-items">{{ $this->verifyUmkm ? $this->verifyUmkm->user->phone : '' }}</div>
                        </div>                    
                    </div>
                    @if ($this->verifyUmkm)
                        <div class="profile-wrapper">
                            <div class="image-container">
                                <img src="{{ asset('storage/'.$this->verifyUmkm->user->photo) }}" alt="{{ $this->verifyUmkm->user ? $this->verifyUmkm->user->full_name : '' }}_pass_foto">
                            </div>
                        </div>                        
                    @endif
                </div>

                <span class="content-title">Informasi UMKM</span>
                <div class="row-wrapper">
                    <span class="input-title">Nama</span>
                    <div class="input-items">{{ $this->verifyUmkm ? $this->verifyUmkm->name : '' }}</div>
                </div>
                <div class="row-wrapper">
                    <span class="input-title">Jenis</span>
                    <div class="input-items">{{ $this->verifyUmkm ? $this->verifyUmkm->type : '' }}</div>
                </div>
                <div class="row-wrapper top-align">
                    <span class="input-title">Surat Rekomendasi</span>
                    <div class="input-items row-button">
                        <button id="recomendation-docs-toggler" type="button" class="btn submit-button ico hovered">
                            <i class="fa-solid fa-eye expand show"></i>
                            <span class="expand show">Lihat</span>
                            <i class="fa-solid fa-chevron-up minimize"></i>
                            <span class="minimize">Tutup</span>
                        </button>
                        @if ($this->verifyUmkm)
                            <div class="docs-wrapper">
                                <div class="image-container">
                                    <img src="{{ asset('storage/'.$this->verifyUmkm->recomendation_docs) }}" alt="{{ $this->verifyUmkm->name }}_rekomendasi">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if ($this->verifyUmkm && $this->verifyUmkm->umkm_images->count() > 0)
                    <div class="row-wrapper top-align">
                        <span class="input-title">Gambar</span>
                        <div class="input-items row-button">
                            <button onclick="expand_umkm_pictures()" id="umkm-picture-toggler" type="button" class="btn submit-button ico hovered">
                                <i class="fa-solid fa-eye expand show"></i>
                                <span class="expand show">Lihat</span>
                                <i class="fa-solid fa-chevron-up minimize"></i>
                                <span class="minimize">Tutup</span>
                            </button>
                            <div class="umkm-picture-wrapper">
                                @foreach ($this->verifyUmkm->umkm_images as $index => $image)
                                    <div class="image-container">
                                        <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $this->verifyUmkm->name }}_gambar_{{ $index }}">
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="message-container @if($this->reject_state) active @endif">
                <span class="title">Tolak Pengajuan</span>
                <textarea wire:model='reject_message' class="main-form-input" placeholder="Pesan alasan penolakan pendaftaran {{  $this->verifyUmkm ? $this->verifyUmkm->type : '' }} ..." rows="6"></textarea>
                @error('reject_message')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="message-container @if($this->acc_state) active @endif">
                <span class="title">Verifikasi Pengajuan</span>
                <div class="row-wrapper">
                    <span class="input-title">Surat Ijin</span>
                    <input wire:model='permission_docs' type="file" class="input-items form-control file">
                    @error('permission_docs')
                        <small class="error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <div class="button-wrapper">
                <button id="log-wrapper-toggler" type="button" class="btn btn-abort hovered ico">
                    <i class="fa-solid fa-list"></i>
                    <span>riwayat aktivasi</span>
                </button>

                @if ($this->reject_state != true && $this->acc_state != true)
                    @if ($this->verifyUmkm && $this->verifyUmkm->status != 'verified' && $this->verifyUmkm->status != 'rejected')
                        <button wire:click='set_acc_state(true)' type="button" class="btn btn-accept">
                            <span>Verifikasi</span>
                        </button>
                        <button wire:click='set_reject_state(true)' type="button" class="btn btn-reject">
                            <span>Tolak</span>
                        </button>    
                    @endif
                @else
                    @if ($this->reject_state)
                        <button style="display: none"></button>
                        <button wire:click='set_reject_state(false)' class="btn btn-abort">Batalkan</button>
                        <button wire:click='reject_request' type="button" class="btn btn-reject">
                            <span>Tolak</span>
                        </button>   
                        @endif
                    @if ($this->acc_state)
                        <button style="display: none"></button>
                        <button wire:click='set_acc_state(false)' class="btn btn-abort">Batalkan</button>
                        <button wire:click='confirm_acc_request' type="button" class="btn btn-accept">
                            <span>Verifikasi</span>
                        </button>   
                    @endif
                @endif

            </div>

            @if ($this->verifyUmkm)
                <div class="log-wrapper">
                    <span class="title">Riwayat Permintaan Aktivasi</span>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Status</th>
                                <th>Pesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->verifyUmkm->activation_log->sortByDesc('created_at') as $log)
                                <tr>
                                    <td>{{ $this->format_datetime($log->created_at, 'd/m/Y') }}</td>
                                    <td>{{ $this->format_datetime($log->created_at, 'H:i') }}</td>
                                    <td>{{ $log->status }}</td>
                                    <td>{{ $log->message }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Belum ada riwayat aktivasi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

        </div>

        <div class="content-menu-wrapper">
            <a wire:click.prevent='set_status_filter("pending")' href="#" class="menu-item @if($status_filter == 'pending') active @endif">Permintaan</a>
            <a wire:click.prevent='set_status_filter("rejected")' href="#" class="menu-item @if($status_filter == 'rejected') active @endif">Ditolak</a>
            <a wire:click.prevent='set_status_filter("verified")' href="#" class="menu-item @if($status_filter == 'verified') active @endif">Diverifikasi</a>
        </div>
        <div class="page-content-card">
            <div class="card-title-wrapper">
                <span class="card-title">Daftar UMKM</span>
            </div>
            <div class="powergrid-table-container">
                <livewire:umkms-table />
            </div>
        </div>


    </div>
</div>


@push('script')
<script>

    // On click table details buttons
    $( window ).on('scroll-up', function () {
        window.location.href = '#verify-page-title'
    })

    $('#recomendation-docs-toggler').click(function () {
        $( this ).toggleClass('active')
        $( this ).find('.minimize').toggleClass('show')
        $( this ).find('.expand').toggleClass('show')

        $('.docs-wrapper').toggleClass('show')
    })

    $('.umkm-picture-toggler').click(function () {
        alert(1)
    })

    function expand_umkm_pictures() {
        $( '#umkm-picture-toggler' ).toggleClass('active')
        $( '#umkm-picture-toggler .minimize' ).toggleClass('show')
        $( '#umkm-picture-toggler .expand' ).toggleClass('show')

        $('.umkm-picture-wrapper').toggleClass('show')        
    }

    $('#log-wrapper-toggler').click(function () {
        $('.log-wrapper').toggleClass('active')
    })

    $( window ).on('show-verify-modal', function () {
        Swal.fire({
            title: "Konfirmasi verifikasi",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak"
            }).then((result) => {
            if (result.isConfirmed) {
                @this.acc_request()
                Swal.fire("Verifikasi berhasil", "", "success");
            }
        });
    })
    
</script>
@endpush