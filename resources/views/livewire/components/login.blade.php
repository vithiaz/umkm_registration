<div wire:ignore.self class="modal fade" id="auth_modal" tabindex="-1">
    <div class="modal-dialog">
        <form wire:submit.prevent='login' class="modal-content">
            @csrf

            <button class="close-modal-button" onclick="hide_auth_modal()" data-bs-dismiss="modal">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="logo-wrapper">
                <img src="{{ asset('image\koperasi_dan_UMKM_RI_logo.png') }}" alt="kemenkopukm-logo">
                <div class="brand">
                    <span class="brand-name">KEMENKOPUKM</span>
                </div>
            </div>

            <div class="title">Masuk</div>
            <div class="form-floating">
                <input wire:model='nip' type="numeric" class="form-control @error('nip') is-invalid @enderror @if(Session::has('error')) is-invalid @endif" id="nip_input" placeholder="NIP">
                <label for="nip_input">NIP</label>
                @error('nip')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-floating">
                <input wire:model='birth' type="date" class="form-control @error('birth') is-invalid @enderror @if(Session::has('error')) is-invalid @endif" id="birth_input">
                <label for="birth_input">Tanggal Lahir</label>
                @error('birth')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>
            @if (Session::has('error'))
                <small class="error">{{ Session::get('error') }}</small>
            @endif
            <button type="submit" class="btn btn-default-dark">
                Masuk
            </button>
            <div class="register-suggest">
                <span>Belum punya akun?</span>
                <a href="#" class="register"> Buat Akun</a>
            </div>
        </form>
    </div>
</div>

@push('script')
<script>

    function hide_auth_modal() {
        $('#auth_modal').modal('hide');
        $('body').removeClass('modal-open');
        // $('.modal-backdrop').remove();
    }

</script>
@endpush