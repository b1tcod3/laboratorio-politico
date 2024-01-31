<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $fillable = [
        'telefono_movil',
        'telefono_movil_aux',
        'email',
        'cuenta_redes_sociales',
        'persona_id'
    ];

    public function persona(): HasOne
    {
        return $this->hasOne(Persona::class);
    }
}
