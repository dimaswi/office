<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cutis';

    protected $fillable = [
        'karyawan',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan_cuti',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'karyawan', 'id');
    }
}
