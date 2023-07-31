@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
@endpush

<div class="homepage">
    <nav class="top-navigator">
        <div class="container">
            @auth
            <div class="button-container">
                <span class="logged-user">{{ Auth::user()->full_name }}</span>
                <button id="navigator-menu-dropdown-toggle" class="btn menu-button"><i class="fa-solid fa-angle-down"></i></button>
            </div>
            <div id="navigator-menu-dropdown" class="menu-dropdown">
                <ul>
                    @if (Auth::user()->is_admin)
                        <li><a href="{{ route('admin.account-verify') }}">Admin Panel</a></li>
                    @else
                        <li><a href="{{ route('profile') }}">Pengaturan Akun</a></li>
                    @endif
                    <li><a href="{{ route('logout') }}">Keluar</a></li>
                </ul>
            </div>
            @else
                <div class="button-container">
                    <button class="btn nav-button-inverse" data-bs-toggle="modal" data-bs-target="#auth_modal">Masuk</button>
                    <a href="{{ route('register') }}" class="nav-button">Daftar</a>
                </div>
            @endauth
        </div>
    </nav>

    <section class="hero" style='background-image: url("{{ asset('image/homepage_bg.jpg') }}")'>
        <div class="container">
            <div class="row-wrapper">
                <div class="main-content-wrapper">
                    <h1 class="page-title">DISKOP<span class="lighter">UKM</span></h1>
                    <span class="page-sub-title">Dinas Koperasi, Usaha Kecil dan Menengah</span>
                    <div class="city-logo-wrapper">
                        <img src="{{ asset('image/logotomohon.png') }}" alt="logo tomohon">
                        <span class="logo-title">KOTA TOMOHON</span>
                    </div>
                </div>
                <div class="sub-content-wrapper">
                    <div class="main-logo-wrapper">
                        <img src="{{ asset('image/koperasi_dan_UMKM_RI_logo.png') }}" alt="koperasi dan UMKM RI logo">
                    </div>
                </div>
            </div>
            <nav class="menu-wrapper">
                <ul>
                    <li><a href="#">BERANDA</a></li>
                    @auth
                        @if (Auth::check() && Auth::user()->is_admin == false)
                            <li><a href="{{ route('umkm-programs') }}">DAFTAR PROGRAM BANTUAN</a></li>
                        @endif                    
                    @else
                        <li><a href="{{ route('register') }}">PENDAFTARAN AKUN</a></li>
                    @endauth

                </ul>
            </nav>
        </div>
    </section>

    <section class="profile">
        <div class="container">
            <div class="section-title-wrapper">
                <h2 class="section-title"><span class="lighter">P</span>ROFIL</h2>    
                <span class="section-subtitle">DISKOPUKM KOTA TOMOHON</span>
            </div>
            <div class="section-content-wrapper">
                <div class="content">
                    <span class="title">Visi</span>
                    <p>Adipisicing et consequat dolor officia ad sint Lorem duis consectetur.</p>
                </div>
                <div class="content">
                    <span class="title">Misi</span>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem eius dignissimos totam quae similique eveniet velit obcaecati vel laboriosam veniam.</p>
                    <p>Et culpa consequat nulla Lorem sit quis veniam labore consequat quis esse labore consequat sunt. Mollit irure laborum enim commodo dolor sit sint. Nostrud amet aute enim elit nisi. Mollit consequat reprehenderit nisi amet officia in. Consequat cupidatat labore sunt excepteur duis eiusmod et laborum sit cupidatat quis incididunt ad. Sit ex sint culpa reprehenderit Lorem irure incididunt adipisicing occaecat tempor occaecat elit quis. Sint aliqua ad nisi amet ea anim. Et sunt duis elit qui nulla consequat fugiat qui.</p>
                    <p>Excepteur amet veniam elit adipisicing consequat incididunt adipisicing adipisicing sit esse. Ea aute occaecat eiusmod ea excepteur veniam pariatur anim cillum duis et deserunt et minim. Magna eiusmod dolor consectetur sunt irure deserunt sit esse mollit Lorem est culpa. Id occaecat adipisicing reprehenderit fugiat pariatur cupidatat et aliquip mollit esse. Ullamco tempor dolor sint incididunt ex qui nostrud ut exercitation anim incididunt. Ad dolor deserunt eiusmod occaecat sit. Veniam consequat occaecat eiusmod nisi veniam Lorem eiusmod nulla qui qui eiusmod elit sint. Sit non eiusmod cupidatat id proident magna aute. Nisi ut veniam aliquip labore irure proident et id nisi cupidatat ea enim minim veniam. Do laborum sit eiusmod Lorem velit elit tempor reprehenderit pariatur Lorem. Laborum pariatur excepteur quis sit occaecat laboris deserunt adipisicing fugiat.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="registration-info">
        <div class="container">
            <div class="section-title-wrapper">
                <h2 class="section-title">PENDAFTARAN KOPERASI DAN UMKM</h2>    
            </div>
        </div>
        <div class="section-content-wrapper">
            <div class="content-box darker">
                <div class="container">
                    <span class="content-title">SIAPKAN <span class="lighter">BERKAS</span> PENDAFTARAN</span>
                </div>
            </div>
            <div class="content-box content">
                <div class="container">
                    <div class="row-item">
                        <div class="number">1</div>
                        <div class="content-wrapper">
                            <span class="title">Kartu Tanda Penduduk <span class="thin">(KTP)</span></span>
                        </div>
                    </div>
                    <div class="row-item">
                        <div class="number">2</div>
                        <div class="content-wrapper">
                            <span class="title">Kartu Keluarga <span class="thin">(KK)</span></span>
                        </div>
                    </div>
                    <div class="row-item">
                        <div class="number">3</div>
                        <div class="content-wrapper">
                            <span class="title">Surat Pengantar</span>
                            <p class="subtitle">Surat pengantar diambil di kantor kelurahan / surat domisili</p>
                        </div>
                    </div>
                    <div class="row-item">
                        <div class="number">4</div>
                        <div class="content-wrapper">
                            <span class="title">Pas Foto</span>
                            <p class="subtitle">Pas foto pemilik usaha, ukuran 3x4 (cm)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="login-register">
        <div class="section-content-wrapper">
            <div class="content-box lighter">
                <div class="container">
                    <div class="description-wrapper">
                        <span>Sudah Memiliki akun?</span>
                    </div>
                    <button href="#" class="btn dark-button" data-bs-toggle="modal" data-bs-target="#auth_modal">Masuk</button>
                </div>
            </div>
            <div class="content-box darker">
                <div class="container">
                    <div class="description-wrapper">
                        <span>Buat akun untuk mengajukan pendaftaran Koperasi dan UMKM.</span><br>
                        <span>Siapkan dokumen yang tertera diatas kemudian lakukan pendaftaran</span>
                    </div>
                    <a href="{{ route('register') }}" class="light-button">Daftar</a>
                </div>
            </div>
        </div>
    </section>
    
    <livewire:components.login />
    
</div>

@push('script')
<script>

    // Handle Top Navigator Dropdown
    function handleDropdownPosition() {
        let menuWrapper = $('.top-navigator .container .button-container')
        let MenuXOffset = menuWrapper.offset().left
        let MenuWidth = menuWrapper.width()
        let windowWidth = $(window).width()
        $('#navigator-menu-dropdown').css('right', windowWidth - (MenuXOffset + MenuWidth))
    }

    $( document ).ready(function () {
        handleDropdownPosition()
    })
    
    $( window ).resize(() => {
        handleDropdownPosition()
        $('#navigator-menu-dropdown-toggle').removeClass('active')
        $('#navigator-menu-dropdown').removeClass('active')

    })

    // handle Navigator Dropdown Toggle
    $('#navigator-menu-dropdown-toggle').click(function () {
        $('#navigator-menu-dropdown').toggleClass('active')
        $(this).toggleClass('active')

    })

</script>
@endpush