<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangRapat extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ruang_rapat';

    protected $fillable = [
        'nama_ruang'
    ];
}
