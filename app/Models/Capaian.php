<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capaian extends Model
{
    use HasFactory;

    protected $table = "tb_capaian";
    public $timestamps = false;

    protected $fillable = [
        'id',
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
        'kategori_capaian'
    ];

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
