<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }

    public function edit(User $user){
        return view('profile.edit', compact('user'));
    }


    // ユーザーのプロフィールを更新する
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if(request()->hasFile('profile_img')) {
            if ($user->profile_img && $user->profile_img != 'default.jpg')
            Storage::disk('public')->delete($user->profile_img);
        }

        $path = $request->file('profile_img')->store('profile_img', 'public');
        $user->profile_img = $path;

        $request->user()->save();

        return Redirect::route('index')->with('status', 'profile-updated');
    }


    // ユーザーのアカウントを削除する
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/login');
    }
}
