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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('email')->unique()->after('name');
            $table->string('phone')->nullable()->after('website');
            $table->string('address')->nullable()->after('phone');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone', 'address', 'state', 'country']);
        });
    }
};
