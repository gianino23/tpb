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
        Schema::table('capaian_kabupatens', function (Blueprint $table) {
            $table->text('keterangan_verifikasi')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('capaian_kabupatens', function (Blueprint $table) {
            $table->dropColumn('keterangan_verifikasi');
        });
    }
};
