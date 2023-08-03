<div class="sidebar-shadow"></div>
<nav class="sidebar admin-sidebar">
    <div class="toggle-btn" id="sidebar-toggle">
        <i class="fa-sharp fa-solid fa-angle-left"></i>        
    </div>

    <div class="content">
        <a href="#" class="logo-hero">
            DISKOPUKM
        </a>
        <span class="page-hero-title">
            Admin Dashboard
        </span>
        <span class="page-title">Menu</span>
        <div class="menu-wrapper">
            <div class="menu-item">
                {{-- <div class="menu-title"> --}}
                <div class="menu-title">
                    <span>Verifikasi</span>
                    <i class="fa-sharp fa-solid fa-angle-down"></i>
                </div>
                <ul class="sub-menu-item-wrapper">
                    <li
                        @if (\Request::route()->getName() == 'admin.account-verify')
                            class="active"
                        @endif
                        >
                        <a href="{{ route('admin.account-verify') }}">Akun</a>
                    </li>
                    <li
                        @if (\Request::route()->getName() == 'admin.umkm-verify')
                            class="active"
                        @endif
                        >
                        <a href="{{ route('admin.umkm-verify') }}">Koperasi / UMKM</a>
                    </li>
                </ul>
            </div>
            <div class="menu-item">
                <div class="menu-title">
                    <span>Program</span>
                    <i class="fa-sharp fa-solid fa-angle-down"></i>
                </div>
                <ul class="sub-menu-item-wrapper">
                    <li
                        @if (\Request::route()->getName() == 'admin.umkm-programs')
                            class="active"
                        @endif
                        >
                        <a href="{{ route('admin.umkm-programs') }}">Bantuan Koperasi / UMKM</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="seperator"></div>
        <div class="auth">
            <div class="image-container">
                @if (Auth::user()->photo)
                    <img src="{{ asset('storage/'.Auth::user()->photo) }}" alt="{{ Auth::user()->id . '-profile' }}">
                @else                    
                    <div class="no-image">
                        <i class="fa-solid fa-user"></i>
                    </div>
                @endif

            </div>
            <span class="username">{{ Auth::user()->full_name }}</span>
            <button type="button" class="logout-button" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
        </div>
    </div>
</nav>


{{-- Logout Modal --}}
<div class="confirmation-modal modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>Keluar dari Halaman ?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-button confirm-button" data-bs-dismiss="modal">Batalkan</button>
                <button onclick="location.href='{{ route('logout') }}'" type="button" class="modal-button abort-button">Logout</button>
            </div>
        </div>
    </div>
</div>





@push('script')
    <script>

        // OnLoad
        $( document ).ready(function() {
            if ( $(window).width() <=  991) {
                setTimeout(function () {
                    $('.admin-sidebar').toggleClass('hide');
                    $('.sidebar-shadow').toggleClass('hide') ;
                    $('#navbar-toggle').toggleClass('expand');
                }, 600);
            }
        });
        
        // Toggle SideBar
        $('#sidebar-toggle').click(function () {
            $('.admin-sidebar').toggleClass('hide');
            $('.sidebar-shadow').toggleClass('hide') ;
            $( this ).toggleClass('expand');
        });

    
        // Expand Menu
        $('.menu-item').each(function() {
            if ($(this).find('.sub-menu-item-wrapper li.active').length > 0) {
                $(this).addClass('active');
                $(this).find('.menu-title').addClass('active');
                $(this).find('.menu-title i').addClass('expand');
            }
        });

        $('.menu-title').click(function () {
            $( this ).toggleClass('active');
            
            if ( $( this ).hasClass('active') ) {
                $( this ).find("i").addClass('expand');
            }
            else {
                $( this ).find("i").removeClass('expand');
            }
        });

    </script>
@endpush