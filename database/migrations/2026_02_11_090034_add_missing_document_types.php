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
        // For MySQL, we modify the enum to include new types.
        if (config('database.default') !== 'sqlite') {
            DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('pakta_integritas', 'cv', 'transkrip', 'laporan_akhir', 'perpanjangan_magang', 'laporan_bulanan', 'surat_jawaban', 'pakta_integritas_signed') NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting enum changes is tricky if data uses the new types.
        // Usually, we skip reverting enum additions in production environments unless necessary.
    }
};
