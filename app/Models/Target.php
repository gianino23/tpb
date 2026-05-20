<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $table = "tb_target";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'tpb_id',
        'no_target',
        'nama_target'
    ];

    public function tpb()
    {
        return $this->belongsTo(Tpb::class, 'tpb_id', 'id');
    }
}
