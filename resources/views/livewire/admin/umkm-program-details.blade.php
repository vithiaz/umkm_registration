@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/umkm-program-details.css') }}">
@endpush

<div class="content-body">
    <div class="container">
        <div class="page-title">
            <h1>Program Bantuan Koperasi / UMKM</h1>
        </div>

        <div class="page-content-card">
            <div class="card-title-wrapper">
                <span class="card-title">{{ $SupportProgram->name }}</span>
            </div>
            <div class="row-wrapper">
                <span class="row-title">Tipe Program</span>
                <span class="row-body">Bantuan {{ $SupportProgram->program_type }}</span>
            </div>
            <div class="row-wrapper">
                <span class="row-title">Pendaftaran</span>
                <span class="row-body">{{ $SupportProgram->open_date }} - {{ $SupportProgram->end_date }}</span>
            </div>
            <div class="row-wrapper">
                <span class="row-title">Kuota</span>
                <span class="row-body">{{ $SupportProgram->umkm->count() }} / {!! $SupportProgram->quota || ($SupportProgram->quota > 0) ? $SupportProgram->quota : '&#8734;'   !!}</span>
            </div>
            <span class="card-content-seperator">
                Deskripsi
            </span>
            <div class="card-content-body">
                {{ $SupportProgram->description }}
            </div>
        </div>

        <div class="page-title secondary">
            <h1>UMKM Terdaftar</h1>
        </div>
        <div class="content-menu-wrapper">
            <a wire:click.prevent='set_status_filter("pending")' href="#" class="menu-item @if($status_filter == 'pending') active @endif">Permintaan</a>
            <a wire:click.prevent='set_status_filter("verified")' href="#" class="menu-item @if($status_filter == 'verified') active @endif">Terdaftar</a>
        </div>
        <div class="page-content-card">
            <div class="powergrid-table-container">
                <livewire:support-program-members-table program_id='{{ $SupportProgram->id }}' />
            </div>
        </div>


    </div>
</div>
