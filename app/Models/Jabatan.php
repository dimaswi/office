<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jabatans';

    protected $fillable = [
        'nama_jabatan'
    ];

    public function cuti()
    {
        return $this->hasMany(Cuti::class);
    }
}
