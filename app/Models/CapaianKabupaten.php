<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaianKabupaten extends Model
{
    protected $fillable = [
        'no_tiket',
        'user_id',
        'wilayah',
        'tpb_id',
        'target_id',
        'indikator_id',
        'rpjmd_id',
        'opd',
        'tahun_n4',
        'tahun_n3',
        'tahun_n2',
        'tahun_n1',
        'tahun_n',
        'gap',
        'kategori_capaian',
        'nama_dokumen',
        'jenis_dokumen',
        'tanggal_kirim',
        'tanggal_terima',
        'status',
        'files'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tpb()
    {
        return $this->belongsTo(Tpb::class);
    }

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class);
    }

    public function rpjmd()
    {
        return $this->belongsTo(Rpjmd::class);
    }
}
