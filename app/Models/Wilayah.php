<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'tb_wilayah';

    protected $fillable = [
        'nama_wilayah',
        'kategori',
        'keterangan'
    ];
}
