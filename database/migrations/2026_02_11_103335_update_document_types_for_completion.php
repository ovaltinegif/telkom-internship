<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('pakta_integritas', 'cv', 'transkrip', 'laporan_akhir', 'surat_permohonan', 'surat_rekomendasi', 'ktm', 'surat_jawaban', 'pakta_integritas_signed', 'sertifikat_kelulusan', 'laporan_penilaian_pkl') NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       //
    }
};
