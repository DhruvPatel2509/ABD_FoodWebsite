@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-md-8">
        <h2 class="playfair fw-bold mb-4" style="color: #c4996c;">Profile Settings</h2>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4 sm:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4 sm:p-8">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4 sm:p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
