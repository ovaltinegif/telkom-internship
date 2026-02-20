<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\StudentProfile;

class ProfileController extends Controller
{
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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        //simpan data tambahan ke tabel student_profiles
        //simpan data tambahan ke tabel student_profiles
        $data = [
            'nim' => $request->nim,
            'university' => $request->university,
            'major' => $request->major,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ];

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($request->user()->studentProfile && $request->user()->studentProfile->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($request->user()->studentProfile->photo);
            }
            $path = $request->file('photo')->store('profile-photos', 'public');
            $data['photo'] = $path;
        }

        $request->user()->studentProfile()->updateOrCreate(
        ['user_id' => $request->user()->id],
            $data
        );

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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
