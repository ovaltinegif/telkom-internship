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
        Schema::table('internships', function (Blueprint $table) {
            // Change enum to string to support all statuses without strict DB constraint check (handled by app)
            $table->string('status')->default('onboarding')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            // Revert is harder on SQLite, but we can try to restore previous state if needed.
            // For now, leaving it as string is safe for down as well since it accepts the old values.
        });
    }
};
