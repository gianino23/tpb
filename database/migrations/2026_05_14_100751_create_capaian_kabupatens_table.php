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
        Schema::create('capaian_kabupatens', function (Blueprint $table) {
            $table->id();
            $table->string('no_tiket')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('wilayah');
            $table->string('nama_dokumen');
            $table->string('jenis_dokumen');
            $table->dateTime('tanggal_kirim')->nullable();
            $table->dateTime('tanggal_terima')->nullable();
            $table->string('status')->default('Menunggu Verifikasi');
            $table->text('files')->nullable(); // Store as JSON or comma separated
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capaian_kabupatens');
    }
};
