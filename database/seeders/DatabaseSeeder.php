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
        // 0. Buat Akun ADMIN
        $adminEmail = 'admin@telkom.co.id';
        User::updateOrCreate(['email' => $adminEmail], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 1. Buat Data Divisi
        $divisionsData = [
            ['name' => 'Business Service', 'description' => 'Pengelolaan layanan bisnis.'],
            ['name' => 'Enterprise Service', 'description' => 'Solusi untuk korporat.'],
            ['name' => 'Government Service', 'description' => 'Layanan untuk pemerintah.'],
            ['name' => 'Human Capital', 'description' => 'Pengelolaan SDM.'],
            ['name' => 'Payment Collection', 'description' => 'Manajemen penagihan.'],
            ['name' => 'Warroom', 'description' => 'Pusat pemantauan jaringan.'],
        ];

        foreach ($divisionsData as $divData) {
            Division::updateOrCreate(['name' => $divData['name']], $divData);
        }

        $allDivisions = Division::all();

        // 2. Buat 3 Akun MENTOR secara terstruktur
        $mentors = [];
        for ($i = 1; $i <= 3; $i++) {
            $mentor = User::updateOrCreate(['email' => "mentor{$i}@telkom.co.id"], [
                'name' => "Mentor {$i}",
                'password' => Hash::make('password'),
                'role' => 'mentor',
            ]);
            MentorProfile::updateOrCreate(['user_id' => $mentor->id], [
                'nik' => fake()->unique()->numerify('##########'),
                'position' => 'Senior Specialist',
                'quota' => 3,
            ]);
            $mentors[] = $mentor;
        }

        // 3. Buat 9 Akun Mahasiswa/Intern (3 per Mentor)
        for ($i = 1; $i <= 9; $i++) {
            $intern = User::updateOrCreate(['email' => "intern{$i}@gmail.com"], [
                'name' => "Intern {$i}",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            StudentProfile::updateOrCreate(['user_id' => $intern->id], [
                'university' => fake()->company(),
                'major' => 'Informatics / Engineering',
                'education_level' => fake()->randomElement(['D3', 'D4', 'S1']),
                'nim' => fake()->unique()->numerify('##########'),
                'phone' => fake()->phoneNumber(),
            ]);

            // Buat Internship Terkait
            $internship = Internship::updateOrCreate(['student_id' => $intern->id], [
                'mentor_id' => $mentors[($i - 1) % 3]->id,
                'division_id' => $allDivisions->random()->id,
                'status' => 'active',
                'start_date' => now()->subMonths(1)->format('Y-m-d'),
                'end_date' => now()->addMonths(2)->format('Y-m-d'),
                'location' => 'Semarang',
            ]);

            // Generate riwayat Absensi & Logbook secara acak (15 hari terakhir)
            for ($d = 0; $d < 15; $d++) {
                $date = now()->subDays($d);
                if (!$date->isWeekend()) {
                    \App\Models\Attendance::updateOrCreate(
                    ['internship_id' => $internship->id, 'date' => $date->format('Y-m-d')],
                    [
                        'status' => 'present',
                        'check_in_time' => '08:00:00',
                        'check_out_time' => '17:00:00',
                        'check_in_lat' => -6.992,
                        'check_in_long' => 110.422,
                    ]
                    );

                    \App\Models\DailyLogbook::updateOrCreate(
                    ['internship_id' => $internship->id, 'date' => $date->format('Y-m-d')],
                    [
                        'activity' => fake()->sentence(8),
                        'status' => 'approved',
                        'mentor_note' => 'Kerja bagus!',
                    ]
                    );
                }
            }
        }
    }
}
