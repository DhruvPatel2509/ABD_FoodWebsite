@extends('admin.layout')
@section('title', 'Users')

@section('content')
<div class="welcome-banner">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="margin: 0; font-size: 26px;">User Management</h1>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">View user roles and update account access levels.</p>
        </div>
        <a href="/admin/dashboard" class="btn" style="background: white; color: var(--sidebar-bg); padding: 10px 20px; border-radius: 10px; font-weight: 700; text-decoration: none;">
            Back to Dashboard
        </a>
    </div>
</div>

<div class="data-card">
    <table class="custom-table">
        <thead>
            <tr>
                <th>#</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>ROLE</th>
                <th>JOINED</th>
                <th style="text-align: right;">ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="font-weight: 700;">{{ $user->name }}</td>
                <td style="color: #64748b;">{{ $user->email }}</td>
                <td>
                    <span style="background: {{ $user->role == 'admin' ? '#fff7ed' : '#fff1f2' }}; color: {{ $user->role == 'admin' ? '#c2410c' : '#e11d48' }}; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td style="color: #94a3b8;">{{ $user->created_at->format('d M Y, h:i A') }}</td>
                <td style="text-align: right;">
                    <a href="{{ url('/admin/userEdit/'.$user->id) }}" style="color: #e11d48; font-weight: 600; text-decoration: none; font-size: 13px; border: 1px solid #fecaca; padding: 5px 12px; border-radius: 6px;">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection