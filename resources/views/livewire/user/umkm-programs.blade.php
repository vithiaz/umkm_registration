@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/umkm-programs.css') }}">
@endpush

@push('navbar')
    @include('layouts.inc.navbar')
@endpush


<div class="umkm-programs">
    <div class="container">
        <div class="page-title">
            <h1>PROGRAM BANTUAN KOPERASI DAN UMKM</h1>
        </div>

        @forelse ($SupportProgram as $program)
            <livewire:user-request-register-umkm 
                :program='$program'
                :activeUmkm='$ActiveUmkm'
                :activeKoperasi='$ActiveKoperasi'
            />
        @empty
            <div class="page-card col-wrap">
                <div class="empty-container">
                    <span>Program bantuan Koperasi dan UMKM belum tersedia ...</span>
                </div>
            </div>
        @endforelse



       
    </div>
</div>
