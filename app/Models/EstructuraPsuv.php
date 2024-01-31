<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstructuraPsuv extends Model
{
    use HasFactory;

    protected $fillable = [
        'cargo_id',
        'persona_id',
        'municipio_id',
        'parroquia_id',
        'comunidad_id',
        'calle_id',
        'centro_electoral_id',
        'verificado',
        'validado'
    ];

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }
    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }
}
