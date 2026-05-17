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
            $table->unsignedBigInteger('tpb_id')->nullable()->after('wilayah');
            $table->unsignedBigInteger('target_id')->nullable()->after('tpb_id');
            $table->unsignedBigInteger('indikator_id')->nullable()->after('target_id');
            $table->unsignedBigInteger('rpjmd_id')->nullable()->after('indikator_id');
            $table->string('opd')->nullable()->after('rpjmd_id');
            $table->string('tahun_n4')->nullable()->after('opd');
            $table->string('tahun_n3')->nullable()->after('tahun_n4');
            $table->string('tahun_n2')->nullable()->after('tahun_n3');
            $table->string('tahun_n1')->nullable()->after('tahun_n2');
            $table->string('tahun_n')->nullable()->after('tahun_n1');
            $table->string('gap')->nullable()->after('tahun_n');
            $table->string('kategori_capaian')->nullable()->after('gap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('capaian_kabupatens', function (Blueprint $table) {
            //
        });
    }
};
