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
        Schema::table('phishing_logs', function (Blueprint $table) {
            $table->string('session_id', 255)->nullable()->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phishing_logs', function (Blueprint $table) {
            $table->dropUnique('phishing_logs_session_id_unique');
            $table->dropColumn('session_id');
        });
    }
};
