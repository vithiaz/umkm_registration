<div class="table-details-container">
    @if ($row->owner_photo)
        <div class="image-container">
                <img src="{{ asset('storage/'.$row->owner_photo) }}" alt="{{ $row->owner_name }}_pas_foto">
        </div>
    @endif
    @if ($row->owner_ktp)
        <div class="image-container">
                <img src="{{ asset('storage/'.$row->owner_ktp) }}" alt="{{ $row->owner_name }}_ktp">
        </div>
    @endif
    @if ($row->owner_kk)
        <div class="image-container">
                <img src="{{ asset('storage/'.$row->owner_kk) }}" alt="{{ $row->owner_name }}_kk">
        </div>
    @endif
    @if ($row->permission_docs)
        <div class="image-container">
                <img src="{{ asset('storage/'.$row->permission_docs) }}" alt="{{ $row->umkm_name }}_rekomendasi">
        </div>
    @endif

    
    
</div>