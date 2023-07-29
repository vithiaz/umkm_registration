<div class="table-details-container">
    @if ($row->recomendation_docs)
        <div class="image-container">
                <img src="{{ asset('storage/'.$row->recomendation_docs) }}" alt="{{ $row->name }}_rekomendasi">
        </div>
    @endif
</div>