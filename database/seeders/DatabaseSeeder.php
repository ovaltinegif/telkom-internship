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
        // 1. Buat Data Divisi
        // Kita cek dulu biar tidak duplikat, atau create baru
    $divGS = Division::create([
            'name' => 'Government Service',
            'description' => 'Layanan teknis & aplikasi untuk pelanggan pemerintahan'
        ]);
        
        // Divisi 2: Access Data Management (ADM)
        $divADM = Division::create([
            'name' => 'Access Data Management',
            'description' => 'Validasi dan pengelolaan data jaringan'
        ]);

        // Divisi 3: CCAN (Corporate Customer) - Tambahan opsi
        Division::create([
            'name' => 'CCAN',
            'description' => 'Penanganan gangguan pelanggan korporat'
        ]);

        // 2. Buat Akun MENTOR (Gunakan akun ini untuk Login nanti)
        $mentor = User::create([
            'name' => 'Bapak Mentor Telkom',
            'email' => 'mentor@telkom.co.id',
            'password' => Hash::make('password'),
            'role' => 'mentor', // Pastikan kolom ini sesuai dengan databases(role/type)
        ]);

        // Buat Profil Mentor
        MentorProfile::create([
            'user_id' => $mentor->id,
            'nik' => '123456789',
            'position' => 'Senior Developer',
        ]);

        // 3. Buat Akun MAHASISWA 1
        $mhs1 = User::create([
            'name' => 'Dzaky Hamid',
            'email' => 'dzaky@student.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // Buat Profil Mahasiswa 1
        StudentProfile::create([
            'user_id' => $mhs1->id,
            'university' => 'Universitas Dian Nuswantoro',
            'major' => 'Sistem Informasi',
            'nim' => 'A11.2023.00001',
            'phone' => '081234567890',
            'address' => 'Semarang',
        ]);

        // 4. Buat Akun MAHASISWA 2
        $mhs2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@student.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // Buat Profil Mahasiswa 2
        StudentProfile::create([
            'user_id' => $mhs2->id,
            'university' => 'UGM',
            'major' => 'Ilmu Komputer',
            'nim' => '12345/UGM/2023',
            'phone' => '08987654321',
            'address' => 'Yogyakarta',
        ]);

        // =========================================================
        // 5. HUBUNGKAN MENTOR & MAHASISWA DI TABEL INTERNSHIPS
        // =========================================================
        
        // Magang Mahasiswa 1 (Dibimbing oleh Mentor di atas)
        Internship::create([
            'student_id' => $mhs1->id,
            'mentor_id'  => $mentor->id, // PENTING: ID Mentor yg login
            'division_id' => $divGS->id,
            'start_date' => '2026-01-12',
            'end_date'   => '2026-02-12',
            'status'     => 'active',
        ]);

        // Magang Mahasiswa 2 (Dibimbing oleh Mentor yang sama)
        Internship::create([
            'student_id' => $mhs2->id,
            'mentor_id'  => $mentor->id, // PENTING: ID Mentor yg login
            'division_id' => $divADM->id,
            'start_date' => '2026-01-15',
            'end_date'   => '2026-02-15',
            'status'     => 'onboarding',
        ]);
    }
}
