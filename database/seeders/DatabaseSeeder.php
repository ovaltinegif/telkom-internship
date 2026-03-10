<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\StudentProfile;
use App\Models\MentorProfile;
use App\Models\Internship;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        User::updateOrCreate(['email' => 'admin@telkom.co.id'], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Create Divisions
        $divisions = [
            ['name' => 'Shared Service and General Support', 'code' => 'SSGS'],
            ['name' => 'Business Service', 'code' => 'BS'],
            ['name' => 'Government Service', 'code' => 'GS'],
            ['name' => 'Performance, Risk, and Quality of Sales', 'code' => 'PRQS'],
        ];
        foreach ($divisions as $divData) {
            Division::updateOrCreate(['name' => $divData['name']], $divData);
        }
        $allDivisions = Division::all();

        // 3. Create exactamente 4 Mentors (Quota 7)
        $mentors = [];
        for ($i = 1; $i <= 4; $i++) {
            $mentor = User::create([
                'name' => "Mentor $i",
                'email' => "mentor$i@telkom.co.id",
                'password' => Hash::make('password'),
                'role' => 'mentor',
            ]);

            MentorProfile::create([
                'user_id' => $mentor->id,
                'nik' => "NIK-M-00$i",
                'position' => 'Senior Developer',
                'quota' => 7,
            ]);

            $mentors[] = $mentor;
        }

        // 4. Create Internships (40 Total)

        // A. 10 Pending (mentor_id = null)
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => "Pending Intern $i",
                'email' => "pending$i@student.com",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
            StudentProfile::create([
                'user_id' => $user->id,
                'university' => 'University A',
                'major' => 'IT',
                'nim' => "NIM-P-00$i"
            ]);
            Internship::create([
                'student_id' => $user->id,
                'status' => 'pending',
                'mentor_id' => null,
                'division_id' => null,
                'start_date' => now()->addDays(7),
                'end_date' => now()->addMonths(3),
            ]);
        }

        // B. 5 Onboarding (mentor_id = null)
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Onboarding Intern $i",
                'email' => "onboarding$i@student.com",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
            StudentProfile::create([
                'user_id' => $user->id,
                'university' => 'University B',
                'major' => 'Design',
                'nim' => "NIM-O-00$i"
            ]);
            Internship::create([
                'student_id' => $user->id,
                'status' => 'onboarding',
                'mentor_id' => null,
                'division_id' => $allDivisions->random()->id,
                'start_date' => now()->addDays(2),
                'end_date' => now()->addMonths(3),
            ]);
        }

        // C. 20 Active (Exactly 5 per mentor, split 10 SMK / 10 Mahasiswa)
        $activeTotal = 0;
        foreach ($mentors as $mIndex => $mentor) {
            for ($i = 1; $i <= 5; $i++) {
                $activeTotal++;
                $isSmk = $activeTotal <= 10;

                $user = User::create([
                    'name' => "Active Intern $activeTotal (" . ($isSmk ? 'SMK' : 'Mahasiswa') . ")",
                    'email' => "active$activeTotal@student.com",
                    'password' => Hash::make('password'),
                    'role' => 'student',
                ]);

                StudentProfile::create([
                    'user_id' => $user->id,
                    'university' => $isSmk ? 'SMK Telkom' : 'University C',
                    'major' => $isSmk ? 'TKJ' : 'Network',
                    'nim' => "NIM-A-00$activeTotal",
                    'education_level' => $isSmk ? 'SMK' : 'S1',
                    'student_type' => $isSmk ? 'siswa' : 'mahasiswa'
                ]);

                Internship::create([
                    'student_id' => $user->id,
                    'status' => 'active',
                    'mentor_id' => $mentor->id,
                    'division_id' => $allDivisions->random()->id,
                    'start_date' => now()->subMonths(1),
                    'end_date' => now()->addMonths(2),
                ]);
            }
        }

        // D. 5 Finished (Randomly assign to mentors)
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Finished Intern $i",
                'email' => "finished$i@student.com",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
            StudentProfile::create([
                'user_id' => $user->id,
                'university' => 'University D',
                'major' => 'Finance',
                'nim' => "NIM-F-00$i"
            ]);
            Internship::create([
                'student_id' => $user->id,
                'status' => 'finished',
                'mentor_id' => $mentors[array_rand($mentors)]->id,
                'division_id' => $allDivisions->random()->id,
                'start_date' => now()->subMonths(4),
                'end_date' => now()->subDays(5),
            ]);
        }
    }
}
