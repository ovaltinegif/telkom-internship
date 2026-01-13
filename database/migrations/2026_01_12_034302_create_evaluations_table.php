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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained()->onDelete('cascade');
    
            // Breakdown Nilai (Skala 0-100)
            $table->integer('discipline_score')->default(0);  // Kedisiplinan
            $table->integer('technical_score')->default(0);   // Kemampuan Teknis
            $table->integer('soft_skill_score')->default(0);  // Komunikasi/Kerjasama
            $table->integer('final_score')->nullable();       // Rata-rata Total
    
            $table->text('feedback')->nullable(); // Pesan kesan mentor untuk mahasiswa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
