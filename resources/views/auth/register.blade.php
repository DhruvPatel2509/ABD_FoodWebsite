@extends('layouts.app')

@section('content')
<div class="auth-section py-5 d-flex align-items-center" style="min-height: 80vh; background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);">
    <div class="container my-5">
        <div class="row w-100 mx-auto overflow-hidden shadow-lg flex-row-reverse" style="max-width: 1100px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); border-radius: 20px;">
            
            <!-- Right Side Image (Dynamic Food Vibe) -->
            <div class="col-md-5 d-none d-md-flex p-0 position-relative" style="background: url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80') center/cover;">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to left, rgba(0,0,0,0.7), rgba(0,0,0,0.2));"></div>
                <div class="position-absolute bottom-0 end-0 p-5 text-white text-end">
                    <h2 class="kudil-font fw-bold" style="font-size: 3rem;">Join the<br>Feast 🍕</h2>
                    <p class="fs-5 opacity-75">Sign up today and get access to exclusive offers and fast delivery.</p>
                </div>
            </div>

            <!-- Left Side Form -->
            <div class="col-md-7 p-5 d-flex flex-column justify-content-center bg-white">
                <div class="text-center mb-5">
                    <div class="d-inline-flex justify-content-center align-items-center rounded-circle bg-warning text-dark mb-3 shadow-sm" style="width: 60px; height: 60px;">
                        <i class="fa fa-user-plus fs-3"></i>
                    </div>
                    <h2 class="kudil-font fw-bold" style="font-size: 2.5rem;">Create Account</h2>
                    <p class="text-muted">Start ordering your favorite food in minutes</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control rounded-pill px-4 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                        <label for="name" class="px-4 text-muted"><i class="fa fa-user me-2"></i>Full Name</label>
                        @error('name')
                            <div class="invalid-feedback ms-4">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-floating mb-4">
                        <input type="email" class="form-control rounded-pill px-4 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                        <label for="email" class="px-4 text-muted"><i class="fa fa-envelope me-2"></i>Email Address</label>
                        @error('email')
                            <div class="invalid-feedback ms-4">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Password -->
                        <div class="col-md-6 mb-4">
                            <div class="form-floating">
                                <input type="password" class="form-control rounded-pill px-4 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                                <label for="password" class="px-4 text-muted"><i class="fa fa-lock me-2"></i>Password</label>
                                @error('password')
                                    <div class="invalid-feedback ms-4">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-4">
                            <div class="form-floating">
                                <input type="password" class="form-control rounded-pill px-4" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                                <label for="password_confirmation" class="px-4 text-muted"><i class="fa fa-check-circle me-2"></i>Confirm</label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn-warning w-100 py-3 mt-3 rounded-pill fw-bold text-dark fs-5 shadow hover-lift" type="submit">
                        <i class="fa fa-paper-plane me-2"></i> SIGN UP
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
                        Sign up with Google
                    </a>

                    <!-- Login Link -->
                    <div class="text-center mt-5">
                        <p class="text-muted mb-0">Already have an account?</p>
                        <a href="{{ route('login') }}" class="text-decoration-none text-dark fw-bold border-bottom border-warning border-2 pb-1 transition-all" style="font-size: 1.1rem;">Log in here</a>
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
