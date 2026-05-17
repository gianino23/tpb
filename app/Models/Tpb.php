<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpb extends Model
{
    use HasFactory;

    protected $table = "tb_tpb";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'no_tpb',
        'nama_tpb',
        'pilar'
    ];

   
}
