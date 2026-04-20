@extends('layouts.app')

@section('content')
<style>
    .about-header { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200'); background-size: cover; padding: 100px 0; color: white; text-align: center; }
</style>

<div class="about-header">
    <div class="container">
        <h1 class="kudil-font display-3 fw-bold">ABD STORY</h1>
        <p class="lead">Traditional Taste Meets Modern Luxury</p>
    </div>
</div>

<div class="container my-5 py-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="kudil-font mb-4">Authentic Multi-Cuisine Since 2026</h2>
            <p class="text-muted fs-5">ABD was founded on a simple principle: to bring the most authentic traditional recipes to the modern table. Every dish we serve is prepared with secret spices passed down through generations.</p>
            <p class="text-muted fs-5">Our chefs use only organic ingredients sourced locally to ensure that every bite you take is fresh, healthy, and bursting with flavor.</p>
            <a href="{{ route('full.menu') }}" class="btn btn-kudil btn-lg mt-3">EXPLORE OUR MENU</a>
        </div>
        <div class="col-md-6">
            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200" class="img-fluid rounded shadow-lg" alt="About ABD">
        </div>
    </div>
</div>
@endsection