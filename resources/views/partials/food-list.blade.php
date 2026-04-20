@forelse($featured as $item)
    <a href="{{ route('food.show', $item->slug) }}" class="search-result-item">
        <img src="{{ $item->image }}" alt="{{ $item->name }}">
        <div class="info">
            <h6>{{ $item->name }}</h6>
            <span>₹{{ $item->price }}</span>
        </div>
    </a>
@empty
    <div class="p-3 text-center text-muted">No dishes found matching your search.</div>
@endforelse