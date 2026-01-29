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
        // Modify internships table
        Schema::table('internships', function (Blueprint $table) {
            // Modify enum is tricky in standard migration without raw SQL or doctrine/dbal for complex changes.
            // For simple additions to enum (which Laravel doesn't natively support altering easily without packages), 
            // sometimes it's better to just change the column definition if possible or use DB::statement.
            
            // Adding new columns
            if (!Schema::hasColumn('internships', 'semester')) {
                $table->string('semester')->after('end_date')->nullable();
            }
            if (!Schema::hasColumn('internships', 'reason')) {
                $table->text('reason')->after('semester')->nullable();
            }
        });

        // For Enum changes, it's safer to use raw SQL for Postgres/MySQL if doctrine/dbal isn't fully set up for enum alteration
        // Or we can just rely on the application to handle validation if the DB is flexible, but for strict Enum in DB:
        if (DB::getDriverName() !== 'sqlite') {
             DB::statement("ALTER TABLE internships MODIFY COLUMN status ENUM('onboarding', 'active', 'finished', 'dropped', 'pending') NOT NULL DEFAULT 'onboarding'");
             DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('pakta_integritas', 'cv', 'transkrip', 'laporan_akhir', 'surat_permohonan') NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->dropColumn(['semester', 'reason']);
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE internships MODIFY COLUMN status ENUM('onboarding', 'active', 'finished', 'dropped') NOT NULL DEFAULT 'onboarding'");
            DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('pakta_integritas', 'cv', 'transkrip', 'laporan_akhir') NOT NULL");
        }
    }
};
