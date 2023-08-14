@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/add-news-page.css') }}">
@endpush

<div class="add-news-page content-body">
    <div class="container">
        <div class="page-title">
            <h1>Informasi dan Berita</h1>
        </div>

        <div class="page-title secondary">
            <h1>Tambahkan Berita</h1>
        </div>
        <form wire:submit.prevent='store_berita' class="page-content-card">
            <div class="row-wrapper">
                <div class="form-wrapper">
                    <div class="form-input-wrapper row">
                        <span class="form-title">Judul</span>
                        <div class="form-items">
                            <input wire:model='title' class="form-input-default" type="text" placeholder="Judul">
                            @error('title')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div id="summernote-container" wire:ignore>
                        <textarea id="summernote" name="news-body"></textarea>
                    </div>
                    @error('body')
                        <small class="error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="button-wrapper">
                <button class="btn submit-button">Tambah Berita</button>
            </div>
        </form>

        <div class="page-title secondary">
            <h1>Daftar Berita</h1>
        </div>
        <div class="content-menu-wrapper">
            <a wire:click.prevent='set_status_filter(true)' href="#" class="menu-item @if($active_status == true) active @endif">Aktif</a>
            <a wire:click.prevent='set_status_filter(false)' href="#" class="menu-item @if($active_status == false) active @endif">Dimatikan</a>
        </div>
        <div class="page-content-card">
            <div class="powergrid-table-container">
                <livewire:news-table />
            </div>
        </div>


    </div>
</div>


@push('script')
<script>

    $(document).ready(function() {
        $('#summernote').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['insert', ['picture']],
            ],
            callbacks: {
                onChange: (contents, $editable) => {
                    @this.set('body', contents);
                }
            },
        });


        $('#summernote-container .note-btn').click(function() {
            let dataTarget = $( this ).attr('data-bs-original-title')
            
            if (dataTarget == 'Font Size') {
                $('.dropdown-fontsize').toggleClass('show')
            }
        })

        $('.dropdown-fontsize .dropdown-item').click(function () {
            $(this).parent().removeClass('show')
        })

    });


    
    
</script>
@endpush