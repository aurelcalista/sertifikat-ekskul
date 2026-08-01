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
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('semester')->nullable()->default('Ganjil');
            $table->string('tahun_ajaran')->nullable()->default('2026/2027');
            $table->string('nilai_akhir')->nullable();
            $table->string('predikat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['semester', 'tahun_ajaran', 'nilai_akhir', 'predikat']);
        });
    }
};
