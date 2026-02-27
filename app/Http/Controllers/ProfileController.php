<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\StudentProfile;
use App\Models\MentorProfile;

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
        if ($request->user()->role === 'student') {
            $data = [];
            if ($request->has('nim'))
                $data['nim'] = $request->nim;
            if ($request->has('university'))
                $data['university'] = $request->university;
            if ($request->has('major'))
                $data['major'] = $request->major;
            if ($request->has('phone_number'))
                $data['phone_number'] = $request->phone_number;
            if ($request->has('address'))
                $data['address'] = $request->address;

            // Handle Photo Upload
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($request->user()->studentProfile && $request->user()->studentProfile->photo) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($request->user()->studentProfile->photo);
                }
                $path = $request->file('photo')->store('profile-photos', 'public');
                $data['photo'] = $path;
            }

            if (!empty($data)) {
                $request->user()->studentProfile()->updateOrCreate(
                ['user_id' => $request->user()->id],
                    $data
                );
            }
        }
        elseif ($request->user()->role === 'mentor') {
            // Update Data Mentor
            $data = [];
            if ($request->has('nik'))
                $data['nik'] = $request->nik;
            if ($request->has('position'))
                $data['position'] = $request->position;
            if ($request->has('phone_number'))
                $data['phone_number'] = $request->phone_number;

            // Handle Photo Upload using same logic
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($request->user()->mentorProfile && $request->user()->mentorProfile->photo) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($request->user()->mentorProfile->photo);
                }
                $path = $request->file('photo')->store('profile-photos', 'public');
                $data['photo'] = $path;
            }

            if (!empty($data)) {
                $request->user()->mentorProfile()->updateOrCreate(
                ['user_id' => $request->user()->id],
                    $data
                );
            }
        }

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
