@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold poppins">Search Results for: <span style="color: #e11d48;">"{{ $query }}"</span></h2>
            <p class="text-muted">{{ $products->count() }} dishes found matching your request.</p>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row g-4">
            @foreach($products as $item)
                <div class="col-6 col-md-4 col-lg-3">
                    <x-grocery-card :item="$item" />
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->appends(['query' => $query])->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <img src="{{ asset('images/no-results.png') }}" style="width: 200px; opacity: 0.5;" onerror="this.style.display='none'">
            <h3 class="mt-4 fw-bold">Oops! No dishes found</h3>
            <p class="text-muted">Try searching for something else like "Pizza" or "Biryani".</p>
            <a href="{{ url('/') }}" class="btn btn-danger rounded-pill px-4 mt-3" style="background: #e11d48; border: none;">
                Back to Home
            </a>
        </div>
    @endif
</div>
@endsection