<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dummy TPB
        \Illuminate\Support\Facades\DB::table('tb_tpb')->insert([
            [
                'no_tpb' => 'TPB 1',
                'nama_tpb' => 'Tanpa Kemiskinan',
                'pilar' => 'Pembangunan Sosial'
            ],
            [
                'no_tpb' => 'TPB 2',
                'nama_tpb' => 'Tanpa Kelaparan',
                'pilar' => 'Pembangunan Sosial'
            ]
        ]);

        // Dummy Target
        \Illuminate\Support\Facades\DB::table('tb_target')->insert([
            [
                'no_target' => '1.1',
                'nama_target' => 'Mengurangi jumlah penduduk miskin'
            ],
            [
                'no_target' => '2.1',
                'nama_target' => 'Mengakhiri kelaparan'
            ]
        ]);

        // Dummy Indikator
        \Illuminate\Support\Facades\DB::table('tb_indikator')->insert([
            [
                'no_indikator' => '1.1.1',
                'nama_indikator_tpb' => 'Persentase penduduk di bawah garis kemiskinan',
                'indikator_rpjmd' => 'Tingkat Kemiskinan',
                'target_rpjmd' => 'Turun 2%',
                'dokumen_pendukung' => '-',
                'catatan' => '-',
                'target_perpres59' => '-',
                'ringkasan_target_perpres59' => '-',
                'kewenangan_kabupaten' => '-',
                'kewenangan_kota' => '-'
            ]
        ]);

        // Dummy RPJMD
        \Illuminate\Support\Facades\DB::table('tb_rpjmd')->insert([
            [
                'no_indikator_rpjmd' => 'RPJMD-001',
                'indikator_kinerja' => 'Meningkatnya Kesejahteraan Masyarakat',
                'spm' => 'Sosial',
                'jenis_urusan' => 'Wajib',
                'kategori_urusan' => 'Pelayanan Dasar',
                'kekhususan_indikator' => '-',
                'referensi' => '-',
                'indikator_sama' => '-'
            ]
        ]);
    }
}
