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
        Schema::create('laporan', function (Blueprint $table) {

            $table->id();

            $table->string('nama_pasien');

            $table->date('tanggal_kunjungan');

            $table->string('nama_dokter');

            $table->string('nama_poli');

            $table->string('no_rm');

            $table->string('nik');

            $table->string('jenis_kelamin');

            $table->text('keluhan_utama');

            $table->text('diagnosa_utama');

            $table->text('diagnosa_sekunder')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};