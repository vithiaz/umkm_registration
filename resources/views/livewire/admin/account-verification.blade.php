@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/account-verification-page.css') }}">
@endpush

<div class="content-body account-verification">
    <div class="container">
        <div class="page-title">
            <h1 id="verify-page-title">Verifikasi Pendaftaran Akun</h1>
        </div>

        <div class="page-verify-card @if($this->verifyAccount) active @endif">
            <div class="card-content">
                <div class="picture-wrapper">
                    <div class="image-container">
                        @if ($this->verifyAccount && $this->verifyAccount->photo)
                            <img src="{{ asset('storage/'.$this->verifyAccount->photo) }}" alt="{{ $this->verifyAccount ? $this->verifyAccount->full_name : '' }}_profile">
                        @else
                            <div class="no-image">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        @endif
                        <div class="no-image">
                            <i class="fa-solid fa-image"></i>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper">
                    <div class="row-wrapper">
                        <span class="input-title">NIK</span>
                        <div class="input-items">
                            <span class="input-detail">{{ $this->verifyAccount ? $this->verifyAccount->nip : '' }}</span>
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Nama Lengkap</span>
                        <div class="input-items">
                            <span class="input-detail">{{ $this->verifyAccount ? $this->verifyAccount->full_name : '' }}</span>
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Jenis Kelamin</span>
                        <div class="input-items">
                            <span class="input-detail">{{ $this->verifyAccount ? $this->verifyAccount->gender : '' }}</span>
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Tanggal Lahir</span>
                        <div class="input-items">
                            <span class="input-detail">{{ $this->verifyAccount ? $this->verifyAccount->birth : '' }}</span>
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Telepon</span>
                        <div class="input-items">
                            <span class="input-detail">{{ $this->verifyAccount ? $this->verifyAccount->phone : '' }}</span>
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Alamat</span>
                        <div class="input-items">
                            <span class="input-detail">{{ $this->verifyAccount ? $this->verifyAccount->address : '' }}</span>
                        </div>
                    </div>
                </div>

                <div class="document-wrapper">
                    <div class="row-wrapper">
                        <div class="input-title right">KTP</div>
                        <div class="input-items">
                            @if ( $this->verifyAccount && $this->verifyAccount->ktp )
                                <div class="image-container">
                                    <img src="{{ asset('storage/'.$this->verifyAccount->ktp) }}" alt="{{ $this->verifyAccount ? $this->verifyAccount->full_name : '' }}_ktp">
                                </div>                                
                            @else
                                <span class="empty">Dokumen tidak di upload</span>                                
                            @endif
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <div class="input-title right">KK</div>
                        <div class="input-items">
                            @if ( $this->verifyAccount && $this->verifyAccount->kk )
                                <div class="image-container">
                                    <img src="{{ asset('storage/'.$this->verifyAccount->kk) }}" alt="{{ $this->verifyAccount ? $this->verifyAccount->full_name : '' }}_kk">
                                </div>                                
                            @else
                                <span class="empty">Dokumen tidak di upload</span>                                
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="message-container @if($this->reject_state) active @endif">
                <span class="title">Tolak Pengajuan</span>
                <textarea wire:model='reject_message' class="main-form-input" placeholder="Pesan alasan penolakan pendaftaran akun ..." rows="6"></textarea>
                @error('reject_message')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="button-wrapper">
                <button id="log-wrapper-toggler" class="btn abort ico hovered">
                    <i class="fa-solid fa-list"></i>
                    <span>riwayat aktivasi</span>
                </button>

                @if ($this->reject_state != true)
                    @if ($this->verifyAccount && $this->verifyAccount->active_status != 'active')
                        <button wire:click='confirm_verify_request' class="btn">Verifikasi</button>
                        <button wire:click='set_reject_state({{ 1 }})' class="btn reject">Tolak</button>                    
                    @endif
                @else
                    <button style="display: none"></button>
                    <button wire:click='set_reject_state({{ 0 }})' class="btn abort">Batalkan</button>
                    <button wire:click='reject_request' class="btn reject">Tolak</button>
                @endif
            </div>

            @if ($this->verifyAccount)
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
                            @forelse ($this->verifyAccount->activation_log->sortByDesc('created_at') as $log)
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
            <a wire:click.prevent='set_status_filter("active")' href="#" class="menu-item @if($status_filter == 'active') active @endif">Aktif</a>
            <a wire:click.prevent='set_status_filter("rejected")' href="#" class="menu-item @if($status_filter == 'rejected') active @endif">Ditolak</a>
        </div>
        <div class="page-content-card">
            <div class="card-title-wrapper">
                <span class="card-title">Daftar Akun</span>
            </div>
            <div class="powergrid-table-container">
                <livewire:users-table />
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
                @this.verify_request()
                Swal.fire("Verifikasi berhasil", "", "success");
            }
        });
    })
    
    $( window ).on('table-show-verify-modal', function (userId) {
        @this.setVerifyData(userId.detail.userId)
        @this.confirm_verify_request()
    })
    

    
</script>
@endpush