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
        if (!User::where('email', 'admin@telkom.co.id')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@telkom.co.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

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
            Division::firstOrCreate(['name' => $divData['name']], $divData);
        }

    // Ambil instance divisi untuk keperluan seeder internship di bawah
    // $divGS = Division::where('name', 'Government Service')->first();
    // $divADM = Division::where('name', 'Human Capital')->first(); 

    // 2. Buat Akun MENTOR (Gunakan akun ini untuk Login nanti)
    // CODE REMOVED AS REQUESTED (Bapak Mentor Telkom)

    // 3. Buat Akun MAHASISWA 1
    // CODE REMOVED AS REQUESTED (Dzaky Hamid)

    // 4. Buat Akun MAHASISWA 2
    // CODE REMOVED AS REQUESTED (Budi Santoso)

    // 5. HUBUNGKAN MENTOR & MAHASISWA DI TABEL INTERNSHIPS
    // CODE REMOVED AS REQUESTED
    }
}
