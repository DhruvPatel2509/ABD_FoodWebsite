@extends('admin.layout')

@section('title', 'Edit User')
@section('header_title', 'Edit User')

@section('content')
    <div class="mx-auto max-w-xl">
        <div class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-white">Edit User</h1>
                    <p class="mt-1 text-sm text-slate-200">Update profile and role for {{ $user->name }}.</p>
                </div>
                <a href="{{ url('/admin/users') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-rose-50">
                    Back to Users
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-md sm:p-7">
            <form action="{{ url('/admin/user/update/' . $user->id) }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Full Name
                    </label>
                    <input type="text" name="name" value="{{ $user->name }}" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        Email Address
                    </label>
                    <input type="email" name="email" value="{{ $user->email }}" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                        User Role
                    </label>
                    <select name="role"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">

                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                            User
                        </option>

                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                    </select>
                </div>

                <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-rose-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700">
                        Update User Data
                    </button>
                    <a href="{{ url('/admin/users') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection