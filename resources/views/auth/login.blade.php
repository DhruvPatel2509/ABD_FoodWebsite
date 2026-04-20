@extends('layouts.app')

@section('content')
<div class="auth-section py-5 d-flex align-items-center" style="min-height: 80vh; background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);">
    <div class="container my-5">
        <div class="row w-100 mx-auto overflow-hidden shadow-lg" style="max-width: 1000px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); border-radius: 20px;">
            
            <!-- Left Side Image (Dynamic Food Vibe) -->
            <div class="col-md-6 d-none d-md-flex p-0 position-relative" style="background: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80') center/cover;">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to right, rgba(0,0,0,0.6), rgba(0,0,0,0.2));"></div>
                <div class="position-absolute bottom-0 start-0 p-5 text-white">
                    <h2 class="kudil-font fw-bold" style="font-size: 3rem;">Premium<br>Taste 🍔</h2>
                    <p class="fs-5 opacity-75">Log in and get your favorite meals delivered blazing fast.</p>
                </div>
            </div>

            <!-- Right Side Form -->
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center bg-white">
                <div class="text-center mb-5">
                    <div class="d-inline-flex justify-content-center align-items-center rounded-circle bg-warning text-dark mb-3 shadow-sm" style="width: 60px; height: 60px;">
                        <i class="fa fa-user fs-3"></i>
                    </div>
                    <h2 class="kudil-font fw-bold" style="font-size: 2.5rem;">Welcome Back</h2>
                    <p class="text-muted">Sign in to continue your delicious journey</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-floating mb-4">
                        <input type="email" class="form-control rounded-pill px-4 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                        <label for="email" class="px-4 text-muted"><i class="fa fa-envelope me-2"></i>Email Address</label>
                        @error('email')
                            <div class="invalid-feedback ms-4">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control rounded-pill px-4 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                        <label for="password" class="px-4 text-muted"><i class="fa fa-lock me-2"></i>Password</label>
                        @error('password')
                            <div class="invalid-feedback ms-4">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-5 px-3">
                        <div class="form-check">
                            <input class="form-check-input border-secondary" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label text-muted small user-select-none" for="remember_me">
                                Remember me
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-warning fw-bold small transition-all">Forgot password?</a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn-warning w-100 py-3 rounded-pill fw-bold text-dark fs-5 shadow hover-lift" type="submit">
                        <i class="fa fa-sign-in-alt me-2"></i> SIGN IN
                    </button>

                    <!-- OR Divider -->
                    <div class="d-flex align-items-center my-4">
                        <hr class="flex-grow-1 text-muted">
                        <span class="px-3 text-muted small fw-bold">OR</span>
                        <hr class="flex-grow-1 text-muted">
                    </div>

                    <!-- Google Button -->
                    <a href="{{ route('social.google') }}" class="btn btn-outline-dark w-100 py-3 rounded-pill fw-bold fs-6 shadow-sm hover-lift d-flex align-items-center justify-content-center">
                        <img src="https://fonts.gstatic.com/s/i/productlogos/googleg/v6/24px.svg" alt="Google Logo" class="me-2" style="width: 20px;">
                        Sign in with Google
                    </a>

                    <!-- Register Link -->
                    <div class="text-center mt-5">
                        <p class="text-muted mb-0">Don't have an account?</p>
                        <a href="{{ route('register') }}" class="text-decoration-none text-dark fw-bold border-bottom border-warning border-2 pb-1 transition-all" style="font-size: 1.1rem;">Create an account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: all 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 25px rgba(255, 193, 7, 0.4) !important;
}
.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
}
.transition-all {
    transition: all 0.2s ease-in-out;
}
.transition-all:hover {
    opacity: 0.8;
}
</style>
@endsection
