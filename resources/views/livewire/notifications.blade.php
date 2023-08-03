@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/notifications-page.css') }}">
@endpush

@push('navbar')
    @include('layouts.inc.navbar')
@endpush

<div class="notifications-page">
    <div class="container">
        <div class="page-title">
            <h1>Notifikasi</h1>
        </div>

        <div class="notification-card-wrapper">
            <span class="section-title">Terbaru</span>
            <div class="card-wrapper">
                @forelse (range(0,2) as $notification)
                    <div class="page-card">
                        <div class="overlay"></div>
        
                        <div class="head-wrapper">
                            <div class="title">Veniam pariatur laboris eiusmod consequat excepteur.</div>
                            <button class="btn expand">
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <button class="btn minimize">
                                <i class="fa-solid fa-window-minimize"></i>
                            </button>
                        </div>
                        <span class="date">01/01/2023 18:30</span>
                        <div class="body-container">
                            <p>Pengajuan Aktivasi UMKM Dentaloc anda ditolak</p>
                            <p>Harap melakukan upload surat keterangan dari kelurahan, karena data yang diupoad tidak bisa dibaca</p>
                        </div>
                    </div>
                @empty
                    <div class="page-card empty">
                        <span>. . .</span>
                        <span>tidak ada notifkasi terbaru</span>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="notification-card-wrapper">
            <span class="section-title">Dibaca</span>
            <div class="card-wrapper">
                @forelse ($this->Notifications as $notification)
                    <div class="page-card">
                        <div class="overlay"></div>
        
                        <div class="head-wrapper">
                            <div class="title">{{ $notification->title }}</div>
                            <button class="btn expand">
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <button class="btn minimize">
                                <i class="fa-solid fa-window-minimize"></i>
                            </button>
                        </div>
                        <span class="date">{{ $notification->created_at }}</span>
                        <div class="body-container">
                            {!! $notification->body !!}
                        </div>
                    </div>
                @empty
                    <div class="page-card empty">
                        <span>. . .</span>
                        <span>tidak ada notifkasi</span>
                    </div>
                @endforelse
            </div>
            <div class="button-wrapper">
                <button class="btn btn-more">Lihat Lainnya</button>
            </div>
        </div>
    </div>
</div>


@push('script')
<script>

    // Handle Card Overlay Hover
    $('.page-card .overlay').hover(
        function () {
            $( this ).parent().addClass('hovered')
        },
        function () {
            $( this ).parent().removeClass('hovered')
        })

    // Handle Card Overlay click
    $('.page-card .overlay').click(function () {
        $( this ).addClass('hidden')
        $( this ).parent().addClass('expand')
    })

    // Handle Minimize Button Click
    $('.page-card .btn.minimize').click(function () {
        let pageCard = $( this ).parent().parent()

        pageCard.find('.overlay').removeClass('hidden')
        pageCard.removeClass('expand')
    })


    
</script>
@endpush