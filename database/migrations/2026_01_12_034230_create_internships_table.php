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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('mentor_id')->nullable()->constrained('users');
            $table->foreignId('project_id')->nullable()->constrained();
            $table->foreignId('division_id')->constrained();
            
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['onboarding', 'active', 'finished', 'dropped'])->default('onboarding');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
