<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rpjmd extends Model
{
    use HasFactory;

    protected $table = "tb_rpjmd";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'wilayah',
        'no_indikator_rpjmd',
        'indikator_kinerja',
        'spm',
        'jenis_urusan',
        'kategori_urusan',
        'kekhususan_indikator',
        'referensi',
        'indikator_sama'
    ];

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'indikator_sama', 'no_indikator');
    }

    
}
