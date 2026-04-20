<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('admin.login');
    }

    public function loginProcess(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        if ($request->user()?->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/');
    }

    public function editUser(int $id): View
    {
        $user = User::findOrFail($id);

        return view('admin.userEdit', compact('user'));
    }

    public function updateUser(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,user'],
        ]);

        $user->update($validated);

        return redirect('/admin/users')->with('success', 'User updated successfully!');
    }

    public function deleteUser(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return redirect('/admin/users')->with('error', 'You cannot delete your own admin account.');
        }

        $user->delete();

        return redirect('/admin/users')->with('success', 'User deleted successfully!');
    }

    public function signupProcess(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user',
        ]);

        return redirect('/Adminlogin')->with('success', 'Registration successful! Please login.');
    }

    public function allUsers(): View
    {
        $users = User::latest()->get();

        return view('admin.users', compact('users'));
    }
}
