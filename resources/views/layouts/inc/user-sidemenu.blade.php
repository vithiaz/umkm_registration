<div id="side-menu" class="menu-container lighten">
    <div class="shadow-placeholder"></div>
    <div id="side-menu-toggle-btn" class="toggle-btn">
        <i class="fa-solid fa-angle-left"></i>
    </div>
    <div class="navigation navigation-menu">
        <div class="nav-header">
            <h1>Menu</h1>
        </div>
        <div class="nav-content">
            <ul id="side-menu-options" class="sub-menu-expand">
                <li
                    @if ( \Request::route()->getName() == 'profile')
                        class="nav-item active"
                    @else
                        class="nav-item"
                    @endif
                    >
                    <a href="{{ route('profile') }}" class="main-item">
                        <span class="nav-item-main">Data Identitas</span>
                    </a>
                </li>
                @if (Auth::user()->active_status != 'active')
                    <li class="nav-item disabled">
                        <span class="main-item">
                            Pendaftaran UMKM
                        </span>
                    </li>
                @else
                    <li
                        @if ( \Request::route()->getName() == 'umkm-registration')
                            class="nav-item active"
                        >
                            <a href="{{ route('umkm-registration') }}" class="main-item">
                                <span class="nav-item-main">Pendaftaran UMKM</span>
                            </a>
                        @else
                            class="nav-item"
                        >
                            <a href="{{ route('umkm-registration') }}" class="main-item">
                                <span class="nav-item-main">Pendaftaran UMKM</span>
                            </a>
                        @endif
                    </li>                    
                @endif
                @if (Auth::user()->active_status != 'active')
                    <li class="nav-item disabled">
                        <span class="main-item">
                            Pendaftaran Koperasi
                        </span>
                    </li>
                @else
                    <li
                        @if ( \Request::route()->getName() == 'koperasi-registration')
                            class="nav-item active"
                        >
                            <a href="{{ route('koperasi-registration') }}" class="main-item">
                                <span class="nav-item-main">Pendaftaran Koperasi</span>
                            </a>
                        @else
                            class="nav-item"
                        >
                            <a href="{{ route('koperasi-registration') }}" class="main-item">
                                <span class="nav-item-main">Pendaftaran Koperasi</span>
                            </a>
                        @endif
                    </li>                    
                @endif
                
                <li
                    @if ( \Request::route()->getName() == 'umkm-programs')
                        class="nav-item active"
                    @else
                        class="nav-item"
                    @endif
                    >
                    <a href="{{ route('umkm-programs') }}" class="main-item">
                        <span class="nav-item-main">Pengajuan Bantuan</span>
                    </a>
                </li>

                <li
                    @if ( \Request::route()->getName() == 'notifications')
                        class="nav-item active"
                    @else
                        class="nav-item"
                    @endif
                    >
                    <a href="{{ route('notifications') }}" class="main-item">
                        <span class="nav-item-main">Notifikasi {{ \Request::route()->getName() == 'notifications' ? '' : '(' . App\Models\UserNotification::where([['user_id', '=', Auth::user()->id],['is_read', '=', false],])->get()->count() . ')' }}</span>
                    </a>
                </li>


                {{-- <li
                    @if (   \Request::route()->getName() == 'cart-page' || 
                            \Request::route()->getName() == 'transaction-page')
                        class="nav-item expand-sub active"
                    @else
                        class="nav-item expand-sub"
                    @endif
                    >
                    <div class="main-item">
                        <span class="nav-item-main">Pesanan Saya</span>
                        <span class="nav-item-secondary arrow-btn">
                            <i class="fa-solid fa-angle-down"></i>
                        </span>
                    </div>
                    <div
                        @if (   \Request::route()->getName() == 'cart-page' || 
                                \Request::route()->getName() == 'transaction-page')
                            class="sub-item expand"
                        @else
                            class="sub-item"
                        @endif
                        >
                        <ul>
                            <li><a href="{{ route('cart-page') }}">Keranjang</a></li>
                            <li><a href="{{ route('transaction-page', ['status' => 'pending']) }}">Transaksi</a></li>
                        </ul>
                    </div>
                </li>
                <li
                    @if (   \Request::route()->getName() == 'umkm.profile' ||
                            \Request::route()->getName() == 'umkm.transaction')
                        class="nav-item expand-sub active"
                    @else
                        class="nav-item expand-sub"
                    @endif
                    >
                    <div class="main-item">
                        <span class="nav-item-main">Zona UMKM</span>
                        <span class="nav-item-secondary arrow-btn">
                            <i class="fa-solid fa-angle-down"></i>
                        </span>
                    </div>
                    <div
                        @if (   \Request::route()->getName() == 'umkm.profile' ||
                                \Request::route()->getName() == 'umkm.transaction')
                            class="sub-item expand"
                        @else
                            class="sub-item"
                        @endif
                        >
                        <ul>
                            <li><a href="{{ route('umkm.profile') }}">Profil</a></li>
                            <li><a href="{{ route('umkm.transaction', ['status' => 'pending']) }}">Transaksi</a></li>
                        </ul>
                    </div>
                </li> --}}


                {{-- <li class="nav-item expand-sub">
                    <div class="main-item">
                        <span class="nav-item-main">Zona UMKM</span>
                        <span class="nav-item-secondary arrow-btn">
                            <i class="fa-solid fa-angle-down"></i>
                        </span>
                    </div>
                    <div class="sub-item">

                    </div>
                </li> --}}

            </ul>
        </div>
    </div>
</div>


@push('script')
<script>

function AdaptSideMenuPositioning() {   
        if ( !$('#navbar').hasClass('scroll-down') ) {
            $('.menu-container .shadow-placeholder').addClass('fill')
            $('#side-menu-toggle-btn').removeClass('higher')
        } else {
            $('.menu-container .shadow-placeholder').removeClass('fill')
            $('#side-menu-toggle-btn').addClass('higher')
        }
    }

    // Toggle Side Menu
    $('#side-menu-toggle-btn').click(function() {
        $('#side-menu').toggleClass('hide')
        $('#side-menu-toggle-btn').toggleClass('hide')
    })

    // Toggle Side Menu - Sub Menu
    $('#side-menu-options .expand-sub .main-item').click(function() {       
        const parent = $( this ).parents('.expand-sub')
        const subMenu = parent.find('.sub-item')
        subMenu.toggleClass('expand')
        parent.toggleClass('expand')
    })



    // Document Mount
    $(document).ready(function() {
        AdaptSideMenuPositioning()
    })

    // Window Scrolling Events
    $(window).scroll(function() {
        AdaptSideMenuPositioning()
    }) 

</script>
@endpush