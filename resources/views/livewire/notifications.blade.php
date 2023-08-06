@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/notifications-page.css') }}">
@endpush

@push('navbar')
    @include('layouts.inc.navbar')
@endpush

<div class="notifications-page">
    <div class="container">
        <div class="page-title">
            <h1>Notifikasi ({{ $this->unread_Notifications->count() }})</h1>
        </div>

        <div class="notification-card-wrapper">
            <span class="section-title">Terbaru</span>
            <div class="card-wrapper">
                
                @forelse ($this->unread_Notifications as $notification)
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
                        <span>tidak ada notifkasi terbaru</span>
                    </div>
                @endforelse


            </div>
        </div>

        <div class="notification-card-wrapper">
            <span class="section-title">Dibaca</span>
            <div class="card-wrapper">
                @forelse ($notifications as $notification)
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
                @if ($this->notif_load_count < $this->Notifications->count())
                    <button wire:click='load_more' class="btn btn-more">Lihat Lainnya</button>
                @endif
            </div>
        </div>
    </div>
</div>


@push('script')
<script>

    function mount_script() {
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
    }

    $( document ).ready(function () {
        mount_script()
    })
    
    $( window ).on('refreshScripts', function () {
        mount_script()
    })


    
</script>
@endpush