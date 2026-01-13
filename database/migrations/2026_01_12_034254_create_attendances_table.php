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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            
            // Koordinat GPS untuk validasi lokasi (Penting buat Telkom!)
            $table->decimal('check_in_lat', 10, 7)->nullable();
            $table->decimal('check_in_long', 10, 7)->nullable();
    
            // Status kehadiran
            $table->enum('status', ['present', 'sick', 'permit', 'alpha'])->default('present');
            $table->text('note')->nullable(); // Alasan jika sakit/izin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
