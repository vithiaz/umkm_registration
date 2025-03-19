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
        @if ($this->User->active_status != 'active')
            <div class="page-content-card information">
                <div class="row-wrapper">
                    <div class="icon-container">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="card-content">
                        <div class="title-container">
                            <span class="title">Informasi</span>
                        </div>
                        <div class="content-body">
                            @if ($this->ActivationMessage)
                                <p>{{ $this->ActivationMessage->message }}</p>
                            @else
                                <p>Pengajuan aktivasi akun anda sedang di proses</p>
                            @endif
                        </div>
                        <div class="content-body">
                            <p>Status: 
                            @if ($this->ActivationMessage)
                                @if ($this->ActivationMessage->status == 'acc')
                                    <span>Terverifikasi</span>
                                @elseif ($this->ActivationMessage->status == 'rejected')
                                    <span>Ditolek</span>
                                @endif
                            @else
                                <span>Proses Pengajuan</span>
                            @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="page-content-card">
            <div class="card-content">
                <div class="picture-wrapper">
                    <div class="image-container">
                        @if ($this->editState)
                            <input wire:model='profile_edit' type="file" id="profile-input" style="display: none">
                            <div onclick="click_input('profile-input')" class="input-trigger-overlay round">
                                <i class="fa-solid fa-pen"></i>
                                <span>Ubah</span>
                            </div>
                        @endif

                        @if ($this->editState && $this->profile_edit && $this->profile_edit->temporaryUrl())
                            <img src="{{ $this->profile_edit->temporaryUrl() }}" alt="{{ $this->User->full_name }}_profile_edit">
                        @else
                            @if ($this->User->photo)
                                <img src="{{ asset('storage/'.$this->User->photo) }}" alt="{{ $this->User->full_name }}_profile">
                            @else
                                <div class="no-image">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif

                        @endif


                        {{-- <div class="no-image">
                            <i class="fa-solid fa-image"></i>
                        </div> --}}
                    </div>
                </div>

                <div class="content-wrapper">
                    @error('profile_edit')
                        <div class="row-wrapper">
                            <div class="input-items">
                                <small class="error">{{ $message }}</small>
                            </div>
                        </div>
                    @enderror
                    <div class="row-wrapper">
                        <span class="input-title">NIK</span>
                        <div class="input-items">
                            @if ($this->editState)
                                <input wire:model='nip_edit' type="text" class="main-form-input">
                                @error('nip_edit')
                                    <small class="error">{{ $message }}</small>
                                @enderror
                            @else
                                <span class="input-detail">{{ $User->nip }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Nama Lengkap</span>
                        <div class="input-items">
                            @if ($this->editState)
                                <input wire:model='fullname_edit' type="text" class="main-form-input">
                                @error('fullname_edit')
                                    <small class="error">{{ $message }}</small>
                                @enderror
                            @else
                                <span class="input-detail">{{ $User->full_name }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Jenis Kelamin</span>
                        <div class="input-items">
                            @if ($this->editState)
                                <select wire:model='gender_edit' class="form-select" aria-label="Pilih jenis kelamin">
                                    <option value="laki-laki">Laki - laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                                @error('gender_edit')
                                    <small class="error">{{ $message }}</small>
                                @enderror
                            @else
                                <span class="input-detail">{{ $User->gender }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Tanggal Lahir</span>
                        <div class="input-items">
                            @if ($this->editState)
                                <input wire:model='birth_edit' type="date" class="main-form-input">
                                @error('birth_edit')
                                    <small class="error">{{ $message }}</small>
                                @enderror
                            @else
                                <span class="input-detail">{{ $User->birth }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Nomor Telepon</span>
                        <div class="input-items">
                            @if ($this->editState)
                                <input wire:model='phone_edit' type="text" class="main-form-input">
                                @error('phone_edit')
                                    <small class="error">{{ $message }}</small>
                                @enderror
                            @else
                                <span class="input-detail">{{ $User->phone }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Alamat</span>
                        <div class="input-items">
                            @if ($this->editState)
                                <input wire:model='address_edit' type="text" class="main-form-input">
                                @error('address_edit')
                                    <small class="error">{{ $message }}</small>
                                @enderror
                            @else
                                <span class="input-detail">{{ $User->address }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="document-wrapper">
                    <div class="row-wrapper">
                        <div class="input-title right">
                            <span>KTP</span>
                            @error('kk_edit')
                                <br><small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="input-items">
                            @if ($this->editState)
                                <input wire:model='ktp_edit' type="file" id="ktp-input" style="display: none">
                                <div onclick="click_input('ktp-input')" class="input-trigger-overlay">
                                    <i class="fa-solid fa-pen"></i>
                                    <span>Ubah</span>
                                </div>
                            @endif

                            @if ($this->editState && $this->ktp_edit && $this->ktp_edit->temporaryUrl())
                                <div class="image-container">
                                    <img src="{{ $this->ktp_edit->temporaryUrl() }}" alt="{{ $this->User ? $this->User->full_name : '' }}_ktp_edit">
                                </div>
                            @else
                                @if ( $this->User->ktp )
                                    <div class="image-container">
                                        <img src="{{ asset('storage/'.$this->User->ktp) }}" alt="{{ $this->User ? $this->User->full_name : '' }}_ktp">
                                    </div>
                                @else
                                    <span class="empty">Dokumen tidak di upload</span>                                
                                @endif
                            @endif

                        </div>
                    </div>
                    <div class="row-wrapper">
                        <div class="input-title right">
                            <span>KK</span>
                            @error('kk_edit')
                                <br><small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="input-items">
                            @if ($this->editState)
                                <input wire:model='kk_edit' type="file" id="kk-input" style="display: none">
                                <div onclick="click_input('kk-input')" class="input-trigger-overlay">
                                    <i class="fa-solid fa-pen"></i>
                                    <span>Ubah</span>
                                </div>
                            @endif

                            @if ($this->editState && $this->kk_edit && $this->kk_edit->temporaryUrl())
                                <div class="image-container">
                                    <img src="{{ $this->kk_edit->temporaryUrl() }}" alt="{{ $this->User ? $this->User->full_name : '' }}_kk_edit">
                                </div>                                                        
                            @else
                                @if ( $this->User->kk )
                                    <div class="image-container">
                                        <img src="{{ asset('storage/'.$this->User->kk) }}" alt="{{ $this->User ? $this->User->full_name : '' }}_kk">
                                    </div>                                
                                @else
                                    <span class="empty">Dokumen tidak di upload</span>                                
                                @endif
                            @endif

                        </div>
                    </div>
                </div>

                @if ($this->User->active_status != 'active')
                    <div class="button-wrapper">
                        @if (!$this->editState)
                            <button wire:click='set_edit_state(true)' class="btn edit-button ico">
                                <i class="fa-solid fa-pen"></i>
                                <span>Ubah</span>
                            </button>
                        @else    
                            <button wire:click='set_edit_state(false)' class="btn abort-button ico">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            <button wire:click='save_edited' class="btn save-button ico">
                                <i class="fa-solid fa-check"></i>
                                <span>Simpan</span>
                            </button>
                        @endif
                    </div>                    
                @endif

            </div>
            
        </div>

        {{-- <div class="page-content-card">
            <div class="card-content">
                <div class="content-wrapper">
                    <div class="row-wrapper">
                        <span class="input-title">NIP</span>
                        <div class="input-items">
                            @if ($this->editState)
                                <input type="text" class="main-form-input" value="{{ $User->nip }}">
                            @else
                                <span class="input-detail">{{ $User->nip }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Nama Lengkap</span>
                        <div class="input-items">
                            @if ($this->editState)
                                <input type="text" class="main-form-input" value="{{ $User->full_name }}">
                            @else
                                <span class="input-detail">{{ $User->full_name }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Jenis Kelamin</span>
                        <div class="input-items">
                            @if ($this->editState)
                                <select class="form-select" aria-label="Pilih jenis kelamin">
                                    <option @if($User->gender == 'laki-laki') selected @endif value="laki-laki">Laki - laki</option>
                                    <option @if($User->gender == 'perempuan') selected @endif value="perempuan">Perempuan</option>
                                </select>
                            @else
                                <span class="input-detail">{{ $User->gender }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Tanggal Lahir</span>
                        <div class="input-items">
                            @if ($this->editState)
                                <input type="date" class="main-form-input" value="{{ $User->birth }}">
                            @else
                                <span class="input-detail">{{ $User->birth }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row-wrapper">
                        <span class="input-title">Alamat</span>
                        <div class="input-items">
                            @if ($this->editState)
                                <input type="text" class="main-form-input" value="{{ $User->address }}">
                            @else
                                <span class="input-detail">{{ $User->address }}</span>
                            @endif
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
                                @if ($this->editState)
                                    <input type="file" id="ktp-input" style="display: none">
                                    <button onclick="click_input('ktp-input')" class="btn row-alert ico">
                                        <i class="fa-solid fa-pen"></i>
                                        <span>ubah</span>
                                    </button>
                                @else
                                    @if ($User->ktp)
                                        <span class="row-detail">diupload</span>
                                        <button class="btn row-info ico">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                    @else
                                        <span class="row-detail">perlu upload</span>
                                        <i class="fa-solid fa-xmark"></i>
                                    @endif                                    
                                @endif

                            </div>
                        </div>
                        <div class="row-wrapper">
                            <span class="row-title">Kartu Keluarga (KK)</span>
                            <div class="row-items">
                                @if ($User->kk)
                                    <span class="row-detail">diupload</span>
                                    <button class="btn row-info ico">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                @else
                                    <span class="row-detail">perlu upload</span>
                                    <i class="fa-solid fa-xmark"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if ($this->User->active_status != 'active')
                    <div class="button-wrapper">
                        @if (!$this->editState)
                            <button wire:click='set_edit_state(true)' class="btn edit-button ico">
                                <i class="fa-solid fa-pen"></i>
                                <span>Ubah</span>
                            </button>
                        @else    
                            <button wire:click='set_edit_state(false)' class="btn abort-button ico">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            <button class="btn save-button ico">
                                <i class="fa-solid fa-check"></i>
                                <span>Simpan</span>
                            </button>
                        @endif
                    </div>                    
                @endif
                

            </div>
        </div> --}}
    </div>
</div>

@push('script')
<script>

    function click_input(target_id) {
        $('#'+target_id).click()
    }

</script>
@endpush
