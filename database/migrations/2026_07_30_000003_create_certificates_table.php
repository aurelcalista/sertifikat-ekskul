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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Format SK-YYYY-XXXXXX
            $table->string('nomor_sertifikat');
            $table->string('nama_siswa');
            $table->string('nis');
            $table->string('sekolah');
            $table->string('kelas');
            $table->string('ekskul');
            $table->string('jenis_sertifikat'); // Kinerja, Prestasi, dll
            $table->string('prestasi')->nullable();
            $table->date('tanggal');
            $table->string('nama_pembina');
            $table->string('jabatan_pembina');
            $table->foreignId('template_id')->nullable()->constrained('templates')->nullOnDelete();
            $table->string('background_path')->nullable(); // Override background
            $table->string('logo_sekolah')->nullable();
            $table->string('tanda_tangan')->nullable();
            $table->string('status')->default('Aktif'); // Aktif, Draft
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
