<div class="table-details-container">
    @if ($row->kk)
        <div class="image-container">
                <img src="{{ asset('storage/'.$row->kk) }}" alt="{{ $row->full_name }}_kk">
        </div>
    @endif
    @if ($row->ktp)
        <div class="image-container">
                <img src="{{ asset('storage/'.$row->ktp) }}" alt="{{ $row->full_name }}_ktp">
        </div>
    @endif
</div>