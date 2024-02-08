<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VotoCalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'persona_id',
        'jefe_familia_id',
        'calle_id',
        'hora_votacion',
        'verificado',
        'calle_id',
        'tipo',
        'es_jefe_familia'
    ];

    public function calle(): BelongsTo
    {
        return $this->belongsTo(Calle::class);
    }
    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }
}
