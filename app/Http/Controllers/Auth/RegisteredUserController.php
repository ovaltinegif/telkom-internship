<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $divisions = \App\Models\Division::all();
        return view('auth.register', compact('divisions'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            // Account Info
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'term' => ['required', 'accepted'], // Terms & Conditions

            // Internship Details
            'division_id' => ['required', 'exists:divisions,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'semester' => ['required', 'string'],
            'duration' => ['required', 'string'],
            'reason' => ['required', 'string'],

            // Profile Info (needed for StudentProfile)
            // Files
            'cv' => ['required', 'file', 'mimes:pdf', 'max:10240'], // 10MB
            'surat_rekomendasi' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'ktm' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'], // KTM can be image or pdf
            'proposal' => ['nullable', 'file', 'mimes:pdf', 'max:10240'], // New: Optional Proposal
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:10240'], // Changed to nullable per user UI change
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // 2. Create User Account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                // 'role' => 'student', // Default might be null or handled by model.
                // Looking at database, role is on users table?
            ]);
            
            // Update role if user table has role column
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'role')) {
                $user->update(['role' => 'student']);
            }

            // Photo Upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('profile-photos', 'public');
            }

            // 3. Create Student Profile
             \App\Models\StudentProfile::create([
                'user_id' => $user->id,
                'nim' => $request->nim ?? 'NIM-'.time(), // Fallback if not in form
                'university' => $request->university ?? 'Unknown University',
                'major' => $request->major ?? 'Unknown Major',
                'phone_number' => $request->phone ?? null,
                'address' => $request->address ?? null,
                'photo' => $photoPath, // Save photo path
            ]);

            // 4. Create Internship Record
            $internship = \App\Models\Internship::create([
                'student_id' => $user->id,
                'division_id' => $request->division_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'semester' => $request->semester,
                'duration' => $request->duration,
                'reason' => $request->reason,
                'status' => 'pending', // Waiting for approval
            ]);

            // 5. Handle File Uploads
            if ($request->hasFile('cv')) {
                $path = $request->file('cv')->store('documents/cv', 'public');
                \App\Models\Document::create([
                    'internship_id' => $internship->id,
                    'name' => 'CV - ' . $user->name,
                    'type' => 'cv',
                    'file_path' => $path,
                ]);
            }

            if ($request->hasFile('surat_rekomendasi')) {
                $path = $request->file('surat_rekomendasi')->store('documents/surat', 'public');
                \App\Models\Document::create([
                    'internship_id' => $internship->id,
                    'name' => 'Surat Rekomendasi - ' . $user->name,
                    'type' => 'surat_rekomendasi',
                    'file_path' => $path,
                ]);
            }

            if ($request->hasFile('ktm')) {
                $path = $request->file('ktm')->store('documents/ktm', 'public');
                \App\Models\Document::create([
                    'internship_id' => $internship->id,
                    'name' => 'KTM - ' . $user->name,
                    'type' => 'ktm',
                    'file_path' => $path,
                ]);
            }

            if ($request->hasFile('proposal')) {
                $path = $request->file('proposal')->store('documents/proposals', 'public');
                \App\Models\Document::create([
                    'internship_id' => $internship->id,
                    'name' => 'Proposal Magang - ' . $user->name,
                    'type' => 'proposal',
                    'file_path' => $path,
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            // Log error
            throw $e;
        }
    }
}
