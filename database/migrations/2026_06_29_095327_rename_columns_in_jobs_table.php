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
        // Use raw SQL to rename columns - avoids default value issues
        if (Schema::hasColumn('jobs', 'status_new') && !Schema::hasColumn('jobs', 'status')) {
            \DB::statement("ALTER TABLE jobs CHANGE COLUMN status_new status ENUM('draft','open','closed') DEFAULT 'draft' NOT NULL");
        }
        if (Schema::hasColumn('jobs', 'job_type_new') && !Schema::hasColumn('jobs', 'job_type')) {
            \DB::statement("ALTER TABLE jobs CHANGE COLUMN job_type_new job_type ENUM('full_time','part_time','contract','internship') DEFAULT 'full_time' NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('jobs', 'status') && !Schema::hasColumn('jobs', 'status_new')) {
            \DB::statement("ALTER TABLE jobs CHANGE COLUMN status status_new ENUM('draft','open','closed') DEFAULT 'draft' NOT NULL");
        }
        if (Schema::hasColumn('jobs', 'job_type') && !Schema::hasColumn('jobs', 'job_type_new')) {
            \DB::statement("ALTER TABLE jobs CHANGE COLUMN job_type job_type_new ENUM('full_time','part_time','contract','internship') DEFAULT 'full_time' NOT NULL");
        }
    }
};
