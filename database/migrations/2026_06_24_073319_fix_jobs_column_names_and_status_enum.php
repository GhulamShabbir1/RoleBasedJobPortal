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
        Schema::table('jobs', function (Blueprint $table) {
            // Rename columns
            $table->renameColumn('created_by', 'user_id');
            $table->renameColumn('dead_line', 'deadline');
            
            // Fix status enum
            $table->enum('status_new', ['draft', 'open', 'closed'])->default('draft');
            $table->update(['status_new' => DB::raw('status')]);
            $table->dropColumn('status');
            $table->renameColumn('status_new', 'status');

            // Fix job type enum
            $table->enum('job_type_new', ['full_time', 'part_time', 'remote', 'contract'])->default('full_time');
            $table->update(['job_type_new' => DB::raw('job_type')]);
            $table->dropColumn('job_type');
            $table->renameColumn('job_type_new', 'job_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Rename columns back
            $table->renameColumn('user_id', 'created_by');
            $table->renameColumn('deadline', 'dead_line');
            
            // Revert status enum
            $table->enum('status_old', ['draft', 'pending', 'open', 'closed'])->default('draft');
            $table->update(['status_old' => DB::raw('status')]);
            $table->dropColumn('status');
            $table->renameColumn('status_old', 'status');

            // Revert job type enum
            $table->enum('job_type_old', ['full_time', 'part_time', 'contract', 'internship'])->default('full_time');
            $table->update(['job_type_old' => DB::raw('job_type')]);
            $table->dropColumn('job_type');
            $table->renameColumn('job_type_old', 'job_type');
        });
    }
};
