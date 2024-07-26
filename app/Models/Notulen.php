<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notulen extends Model
{
    use HasFactory;

    protected $table = 'notulens';

    protected $fillable = [
        'rapat_id',
        'user_id',
        'notulen',
    ];

    public function rapat(): BelongsTo
    {
        return $this->belongsTo(Rapat::class, 'rapat_id', 'id');
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
