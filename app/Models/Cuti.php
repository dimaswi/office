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
        'kepala_unit',
        'kepala_bagian',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'karyawan', 'id');
    }

    public function kanit()
    {
        return $this->belongsTo(Unit::class, 'kepala_unit', 'id');
    }

    public function kabag()
    {
        return $this->belongsTo(Bagian::class, 'kepala_bagian', 'id');
    }
}
