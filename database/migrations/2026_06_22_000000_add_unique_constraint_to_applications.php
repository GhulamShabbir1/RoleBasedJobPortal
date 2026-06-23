<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds unique constraint to prevent duplicate applications from same candidate to same job
     */
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Add unique constraint on (job_id, candidate_id)
            // This prevents the same candidate from applying twice to the same job
            $table->unique(['job_id', 'candidate_id'], 'unique_job_candidate_application');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropUnique('unique_job_candidate_application');
        });
    }
};
