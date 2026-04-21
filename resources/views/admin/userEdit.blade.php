@extends('admin.layout')
@section('title', 'Edit User')

@section('content')
<div class="welcome-banner">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="margin: 0; font-size: 26px;">Edit User Profile</h1>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Update account details and permissions for <strong>{{ $user->name }}</strong>.</p>
        </div>
        <a href="{{ url('/admin/users') }}" class="btn" style="background: white; color: var(--sidebar-bg); padding: 10px 20px; border-radius: 10px; font-weight: 700; text-decoration: none; border: none; cursor: pointer;">
            <i class="fa-solid fa-arrow-left"></i> Back to Users
        </a>
    </div>
</div>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="data-card" style="padding: 40px;">
        <form action="{{ url('/admin/userUpdate/'.$user->id) }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
                
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-weight: 700; color: var(--text-dark); font-size: 14px;">Full Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" 
                           style="padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; font-size: 14px;" required>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-weight: 700; color: var(--text-dark); font-size: 14px;">Email Address</label>
                    <input type="email" name="email" value="{{ $user->email }}" 
                           style="padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; font-size: 14px;" required>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-weight: 700; color: var(--text-dark); font-size: 14px;">User Role</label>
                    <select name="role" style="padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; font-size: 14px; background: white;">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Customer)</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Staff)</option>
                    </select>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-weight: 700; color: var(--text-muted); font-size: 14px;">Member Since</label>
                    <input type="text" value="{{ $user->created_at->format('d M Y') }}" 
                           style="padding: 12px; border: 1px solid #f1f5f9; border-radius: 10px; background: #f8fafc; color: var(--text-muted); cursor: not-allowed;" readonly>
                </div>
            </div>

            <div style="margin-top: 40px; display: flex; justify-content: flex-end; gap: 15px;">
                <a href="{{ url('/admin/users') }}" style="padding: 12px 25px; border-radius: 10px; text-decoration: none; color: var(--text-muted); font-weight: 600; font-size: 14px;">Cancel</a>
                <button type="submit" style="background: var(--sidebar-bg); color: white; border: none; padding: 12px 35px; border-radius: 10px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(225, 29, 72, 0.2);">
                    Update User Details
                </button>
            </div>
        </form>
    </div>
</div>
@endsection