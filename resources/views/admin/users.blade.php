@extends('admin.layout')

@section('title', 'Users')
@section('header_title', 'Users')

@section('content')
    <div class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-white">User Management</h1>
                <p class="mt-1 text-sm text-slate-200">View user roles and update account access levels.</p>
            </div>
            <a href="{{ url('/admin/dashboard') }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-rose-50">
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md">
        <div class="overflow-x-auto">
        <table class="min-w-full text-left">
            <thead class="bg-slate-50 text-slate-700 text-xs uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Joined</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">

                @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-semibold text-slate-800">
                            {{ $user->name }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $user->email }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $user->role == 'admin' ? 'bg-amber-100 text-amber-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            {{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ url('/admin/userEdit/' . $user->id) }}"
                                class="inline-flex items-center rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">
                                Edit
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-slate-400">
                            No users found
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        </div>
    </div>
@endsection