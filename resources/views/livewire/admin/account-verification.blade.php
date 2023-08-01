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
                        <span class="input-title">NIP</span>
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
                <textarea wire:model='reject_message' class="main-form-input" placeholder="Pesan alasan penolakan pendaftaran akun ..." rows="6"></textarea>
                @error('reject_message')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="button-wrapper">
                @if ($this->reject_state != true)
                    <button wire:click='verify_request' class="btn">Verifikasi</button>
                    <button wire:click='set_reject_state({{ 1 }})' class="btn reject">Tolak</button>                    
                @else
                    <button style="display: none"></button>
                    <button wire:click='set_reject_state({{ 0 }})' class="btn abort">Batalkan</button>
                    <button wire:click='reject_request' class="btn reject">Tolak</button>
                @endif
            </div>
            
        </div>

        <div class="content-menu-wrapper">
            <a wire:click.prevent='set_status_filter("pending")' href="#" class="menu-item @if($status_filter == 'pending') active @endif">Permintaan</a>
            <a wire:click.prevent='set_status_filter("active")' href="#" class="menu-item @if($status_filter == 'active') active @endif">Aktif</a>
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
        
        // var href = $('#verify-page-title').attr('href');
        window.location.href = '#verify-page-title';

    })
    
</script>
@endpush