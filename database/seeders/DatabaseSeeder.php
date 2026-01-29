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
        // 0. Buat Akun ADMIN (Gunakan akun ini untuk Login nanti)
        User::create([
        'name' => 'Super Admin',
        'email' => 'admin@telkom.co.id',
        'password' => Hash::make('password'),
        'role' => 'admin', // Pastikan role ini ada
    ]);
        // 1. Buat Data Divisi
        $divisions = [
            [
                'name' => 'Business Service',
                'description' => 'Pengelolaan layanan bisnis dan kemitraan strategis.'
            ],
            [
                'name' => 'Enterprise Service',
                'description' => 'Solusi dan layanan untuk pelanggan korporat skala besar.'
            ],
            [
                'name' => 'Government Service',
                'description' => 'Layanan teknis & aplikasi untuk pelanggan pemerintahan.'
            ],
            [
                'name' => 'Human Capital',
                'description' => 'Pengelolaan sumber daya manusia dan pengembangan talenta.'
            ],
            [
                'name' => 'Payment Collection',
                'description' => 'Manajemen penagihan dan pembayaran.'
            ],
            [
                'name' => 'Warroom',
                'description' => 'Pusat pemantauan dan pengendalian operasional jaringan.'
            ],
        ];

        foreach ($divisions as $divData) {
            Division::create($divData);
        }

        // Ambil instance divisi untuk keperluan seeder internship di bawah
        $divGS = Division::where('name', 'Government Service')->first();
        // Since original logic used $divADM, let's pick another one for the second student
        $divADM = Division::where('name', 'Human Capital')->first(); // Using Human Capital as a substitute example

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
            'email' => 'dzaky@student.co.id',
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
            'email' => 'budi@student.co.id',
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
