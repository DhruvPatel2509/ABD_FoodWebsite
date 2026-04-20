<section>
    <header class="mb-4">
        <h4 class="fw-bold mb-1" style="color: #c4996c;">Profile Information</h4>
        <p class="text-muted small">Update your account's profile information and email address.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Avatar Section -->
        <div class="mb-4 d-flex align-items-center gap-4">
            <div>
                @if($user->avatar)
                <img class="rounded-circle object-cover border shadow-sm" style="width: 100px; height: 100px; border-color: #fc8019 !important;" src="{{ asset($user->avatar) }}" alt="Avatar" />
                @else
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow-sm border" style="width: 100px; height: 100px;">
                    <i class="fa fa-camera fa-2x text-muted opacity-50"></i>
                </div>
                @endif
            </div>
            <div>
                <label class="form-label fw-bold small text-muted mb-2 d-block">Profile Photo</label>
                <input type="file" name="avatar" accept="image/*" class="form-control form-control-sm" style="max-width: 250px;" />
            </div>
        </div>

        <div class="mb-4">
            <label for="name" class="form-label fw-bold small text-muted">Name</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-bold small text-muted">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted small mb-2">
                        Your email address is unverified.
                        <button form="send-verification" class="btn btn-link p-0 text-decoration-none" style="color: #c4996c;">
                            Click here to re-send the verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success small fw-bold mt-2">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 mt-4 pt-2">
            <button type="submit" class="btn text-white fw-bold px-4 rounded-pill shadow-sm" style="background-color: #c4996c; transition: all 0.3s; padding: 10px 30px;">Save Profile</button>

            @if (session('status') === 'profile-updated')
                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-success small fw-bold">
                    <i class="fa fa-check-circle me-1"></i> Saved successfully.
                </span>
            @endif
        </div>
    </form>
</section>
