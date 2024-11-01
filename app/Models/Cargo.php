<?php
namespace App\Models;

use App\Enums\NivelCargoEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'organizacion_id',
        'nivel',
        'area',
    ];

    protected $appends = ['nivel_cargo'];

    protected function casts(): array
    {
        return [
            'nivel' => NivelCargoEnum::class,
        ];
    }

    protected function nivelCargo(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => NivelCargoEnum::from($attributes['nivel'])->name
        );

    }
}
