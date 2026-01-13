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
        Schema::create('mentor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Relasi ke divisi (Bisa null kalau belum diassign)
            $table->foreignId('division_id')->nullable()->constrained('divisions'); 
            $table->string('nik')->unique(); // NIK Karyawan Telkom
            $table->string('position');      // Jabatan (Misal: Officer 3 Digital)
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_profiles');
    }
};
