@push('stylesheet')
    {{-- <link rel="stylesheet" href="{{ asset('css/account-verification-page.css') }}"> --}}
@endpush

<div class="content-body">
    <div class="container">
        <div class="page-title">
            <h1>Program Bantuan UMKM</h1>
        </div>

        <div class="page-title secondary">
            <h1>Tambahkan Program</h1>
        </div>
        <form wire:submit.prevent='store_program' class="page-content-card">
            <div class="row-wrapper">
                <div class="row-item-wrapper form-wrapper">
                    {{-- <div class="form-input-wrapper row">
                        <span class="form-title">Bantuan</span>
                        <div class="form-items">
                            <select wire:model='program_type' id="input-category-select">
                                <option value="" selected hidden>Pilih bantuan</option>
                                <option value="Koperasi">Koperasi</option>
                                <option value="UMKM">UMKM</option>
                            </select>
                            @error('program_type')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="form-input-wrapper row">
                        <span class="form-title">Nama Program</span>
                        <div class="form-items">
                            <input wire:model='name' class="form-input-default" type="text" placeholder="Nama Program">
                            @error('name')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper row">
                        <span class="form-title">Kuota</span>
                        <div class="form-items">
                            <input wire:model='quota' class="form-input-default" type="number" placeholder="Kuota">
                            @error('quota')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper row">
                        <span class="form-title">Tanggal Pendaftaran</span>
                        <div class="form-items">
                            <input wire:model='open_date' class="form-input-default" type="date">
                            @error('open_date')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper row">
                        <span class="form-title">Penutupan Pendaftaran</span>
                        <div class="form-items">
                            <input wire:model='end_date' class="form-input-default" type="date">
                            @error('end_date')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper column">
                        <span class="form-title">Deskripsi</span>
                        <div class="form-items">
                            <textarea wire:model='description' rows="4" class="form-input-default" type="text" placeholder="Deskripsi program ..."></textarea>
                            @error('description')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row-item-wrapper">
                    <div class="button-wrapper">
                        <button class="btn submit-button">Tambah Program</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="page-title secondary">
            <h1>Daftar Program</h1>
        </div>
        <div class="content-menu-wrapper">
            <a wire:click.prevent='set_status_filter(true)' href="#" class="menu-item @if($active_status == true) active @endif">Berjalan</a>
            <a wire:click.prevent='set_status_filter(false)' href="#" class="menu-item @if($active_status == false) active @endif">Selesai</a>
        </div>
        <div class="page-content-card">
            <div class="powergrid-table-container">
                <livewire:admin.support-program-table />
            </div>
        </div>


    </div>
</div>
