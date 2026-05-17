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
        'no_target',
        'nama_target'
    ];

   
}
