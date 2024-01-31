<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataComunidad extends Model
{
    use HasFactory;

    protected $casts = [
    'tipo' => TipoDataEnum::class,
    ];

    protected $fillable = [
        'value_numeric',
        'value_text',
        'value_enum',
        'comunidad_id',
        'tipo'
    ];
}
