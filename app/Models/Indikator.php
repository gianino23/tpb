<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    use HasFactory;

    protected $table = "tb_indikator";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'target_id',
        'no_indikator',
        'nama_indikator_tpb',
        'indikator_rpjmd',
        'target_rpjmd',
        'dokumen_pendukung',
        'catatan',
        'target_perpres59',
        'ringkasan_target_perpres59',
        'kewenangan_kabupaten',
        'kewenangan_kota'
    ];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }
}
