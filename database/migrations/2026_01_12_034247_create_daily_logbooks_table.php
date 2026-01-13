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
        Schema::create('daily_logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->text('activity'); // Deskripsi kegiatan hari ini
            $table->string('evidence')->nullable(); // Foto bukti kegiatan
            // Status approval dari mentor
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('mentor_note')->nullable(); // Komentar mentor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_logbooks');
    }
};
