<?php

namespace App\Models;

use App\Enums\TipoDataEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCentroElectoral extends Model
{
    use HasFactory;

    protected $table = 'data_centro_electorales';

    protected $casts = [
    'tipo' => TipoDataEnum::class,
    ];

    protected $fillable = [
        'value_numeric',
        'value_text',
        'value_enum',
        'centro_electoral_id',
        'tipo'
    ];
}
