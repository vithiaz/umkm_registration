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
                        <li><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
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
                    <p>Tomohon Maju, Berdaya Saing Dan Sejahtera</p>
                </div>
                <div class="content">
                    <span class="title">Misi</span>
                    <p>Menjaga dan Melestarikan Tomohon sebagai Kota Religius</p>
                    <p>Peningkatan Kesejahteraan Masyarakat di Berbagai Sektor</p>
                    <p>Menjadikan Tomohon Sebagai Kota Wisata Dunia</p>
                    <p>Memajukan Sistem Pertanian Dalam Rangka Mewujudkan Kedaulatan Pangan</p>
                    <p>Mewujudkan Pelayanan Pemerintahan Yang Bersih, Efektid dan Berintegritas</p>
                </div>
            </div>
        </div>
    </section>

    <section class="structure">
        <div class="container">
            <div class="section-title-wrapper">
                <h2 class="section-title"><span class="lighter">S</span>TRUKTUR ORGANISASI</h2>
                <div class="button-toggler" id="structure-toggler">
                    <i class="fa-solid fa-angle-down"></i>
                </div>
            </div>
            <div class="section-content-wrapper" id="structure-container">
                <div class="image-container">
                    <img src="{{ asset('image\org_tree.png') }}" alt="struktur organisasi DISKOPUKM KOTA TOMOHON">
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


    <section class="chart-info">
        <div class="container">
            <div class="section-title-wrapper">
                <h2 class="section-title">INFORMASI UMKM DAN KOPERASI AKTIF</h2>    
            </div>
            <div class="section-content-wrapper">
                <div class="content-box">
                    <div class="bar-chart-container">
                        <div class="canvas-container">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="content-box">
                    <div class="bar-chart-container">
                        <div class="canvas-container donut">
                            <canvas id="umkmPerDistrictChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="content-box">
                    <div class="bar-chart-container">
                        <div class="canvas-container donut">
                            <canvas id="koperasiPerDistrictChart"></canvas>
                        </div>
                    </div>
                </div>
                
    
                {{-- <div class="content-box darker">
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
                </div> --}}
            </div>
        </div>
    </section>

    <section class="login-register">
        <div class="section-content-wrapper">
            <div class="content-box lighter">
                <div class="container">
                    @auth
                        <div class="description-wrapper">
                            <span>Anda Login Sebagai {{ Auth::user()->full_name }}</span>
                        </div>
                    @else
                        <div class="description-wrapper">
                            <span>Sudah Memiliki akun?</span>
                        </div>
                        <button href="#" class="btn dark-button" data-bs-toggle="modal" data-bs-target="#auth_modal">Masuk</button>
                    @endauth
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

    <section class="news">
        <div class="container">
            <div class="section-title-wrapper">
                <h2 class="section-title">INFORMASI DAN BERITA</h2>    
            </div>
            <div class="section-content-wrapper">
                @forelse ($News as $news)
                    <div class="page-card">
                        <div class="overlay"></div>
        
                        <div class="head-wrapper">
                            <div class="title">{{ $news->title }}</div>
                            <button class="btn expand">
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <button class="btn minimize">
                                <i class="fa-solid fa-window-minimize"></i>
                            </button>
                        </div>
                        <span class="date">{{ $news->created_at }}</span>
                        <div class="body-container">
                            {!! $news->body !!}
                        </div>
                    </div>
                @empty
                    <div class="page-card empty">
                        <span>. . .</span>
                        <span>Belum ada Informasi / Berita</span>
                    </div>
                @endforelse
            </div>
            <div class="pagination-wrapper">
                {{ $News->links() }}
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



    // Page Card Scripts
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


    // Chart
    const countByLocation = (sub_district, labels) => {
        let count = []
        labels.forEach(label => {
            count.push(sub_district[label].length)
        });

        return count
    }

    const createDoughnut = (title, ctx_id, sub_district_data, label) => {
        const ctx = $(ctx_id);
        new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: label,
            datasets: [{
            label: 'Jumlah',
            data: countByLocation(sub_district_data, label),
            borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    display: false,
                },
                y: {
                    display: false,
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: title,
                    color: '#2A2A2A',
                    font: {
                        size: 20,
                        weight: 'bold',
                        lineHeight: 1.2,
                    },
                }
            }
        }
        });
    }

    const createBarChart = (ctx_id, labels, data) => {
        const bar_ctx = $(ctx_id);
        new Chart(bar_ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'jumlah',
                data: data,
                borderWidth: 1,
                backgroundColor: [
                    '#4270EE',
                    '#F92727',
                ],
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Koperasi / UMKM Aktif',
                    color: '#2A2A2A',
                    font: {
                        size: 20,
                        weight: 'bold',
                        lineHeight: 1.2,
                    },
                },
                legend: {
                    position: 'top'
                },
            },
            indexAxis: 'y',
        }
        });
    }

    $(document).ready(() => {
        createBarChart('#barChart', ['UMKM', 'Koperasi'], [@this.umkm_count, @this.koperasi_count])
        createDoughnut('UMKM Aktif per Kecamatan', '#umkmPerDistrictChart', @this.umkm_sub_district, @this.umkm_sub_district_label)
        createDoughnut('Koperasi Aktif per Kecamatan', '#koperasiPerDistrictChart', @this.koperasi_sub_district, @this.koperasi_sub_district_label)
    })


    // Organization Structure Toggler
    $('#structure-toggler').click(function () {
        $( this ).toggleClass('active')
        $('#structure-container').toggleClass('show')
    })
    $('#structure-toggler').mouseenter(function () {
        $( this ).toggleClass('active')
        $('#structure-container').toggleClass('show')
    })



</script>
@endpush