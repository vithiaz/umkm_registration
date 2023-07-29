@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/account-verification-page.css') }}">
@endpush

<div class="content-body account-verification">
    <div class="container">
        <div class="page-title">
            <h1>Verifikasi Pendaftaran Akun</h1>
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
