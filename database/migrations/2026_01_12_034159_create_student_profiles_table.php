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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nim')->unique(); // NIM Mahasiswa
            $table->string('university');    // Asal Kampus
            $table->string('major');         // Jurusan (Misal: S1 Sistem Informasi)
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable(); // Foto Profil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
