<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\TipoOrganizacionEnum;

class Organizacion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'logo',
        'acronimo',
        'tipo',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['tipo_organizacion'];

     protected $table = 'organizaciones';

       /**
     * Get the name tipo organizacion.
     */
    protected function tipoOrganizacion(): Attribute
    {
         return Attribute::make(
            get: fn (mixed $value, array $attributes) => TipoOrganizacionEnum::from($attributes['tipo'])->name
        );
    }
}
