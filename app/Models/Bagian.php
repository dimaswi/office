<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bagian extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'bagians';

    protected $fillable = [
        'nama_bagian',
        'kepala_bagian',
        'kode_bagian',
        'kop',
    ];

    public function kepala(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kepala_bagian');
    }

    public function unit()
    {
        return $this->hasMany(Unit::class);
    }
}
