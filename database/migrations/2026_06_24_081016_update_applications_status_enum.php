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
        Schema::table('applications', function (Blueprint $table) {
            $table->timestamp('applied_at')->nullable()->change();
            $table->enum('status', ['pending', 'reviewed', 'accepted', 'rejected'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('applied_at')->nullable()->change();
            $table->enum('status', ['pending', 'shortlist', 'reviewed', 'hired', 'rejected'])->default('pending')->change();
        });
    }
};
