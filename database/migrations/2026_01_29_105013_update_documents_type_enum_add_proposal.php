<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('pakta_integritas', 'cv', 'transkrip', 'laporan_akhir', 'surat_permohonan', 'proposal') NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('pakta_integritas', 'cv', 'transkrip', 'laporan_akhir', 'surat_permohonan') NOT NULL");
        }
    }
};
