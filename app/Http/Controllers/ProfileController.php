<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Path constant for consistency
    private const AVATAR_PATH = 'images/avatars/';

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            // 1. Delete old avatar if it exists
            if ($user->avatar) {
                $oldPath = public_path(self::AVATAR_PATH . $user->avatar);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // 2. Process new avatar
            $file = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Move to public/images/avatars/
            $file->move(public_path(self::AVATAR_PATH), $filename);

            // 3. Save only the filename
            $user->avatar = $filename;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Optional: Delete the avatar file when account is deleted
        if ($user->avatar) {
            $path = public_path(self::AVATAR_PATH . $user->avatar);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}