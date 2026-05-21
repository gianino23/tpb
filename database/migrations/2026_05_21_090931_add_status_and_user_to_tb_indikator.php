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
        Schema::table('tb_indikator', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('Menunggu Validasi');
            $table->text('keterangan_verifikasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_indikator', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'status', 'keterangan_verifikasi']);
        });
    }
};
