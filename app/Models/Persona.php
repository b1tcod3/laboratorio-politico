<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Enums\SexoEnum;

class Persona extends Model
{
    use HasFactory;

    protected $casts = [
    'fecha_nacimiento' => 'datetime:d/m/Y',
    'sexo' => SexoEnum::class,
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('personas.nombres', 'like', '%'.$search.'%')
                ->orWhere('personas.apellidos', 'like', '%'.$search.'%')
                ->orWhere('personas.id', 'like', '%'.$search.'%')
                ->orWhere('personas.sexo', 'like', '%'.$search.'%');
            });
        });

        $query->when($filters['municipio'] ?? 'ACOSTA', function ($query, $municipio) {
            $query->where(function ($query) use ($municipio) {
                $query->where('municipios.nombre', $municipio);
            });
        });

        // $query->when($filters['parroquia'] ?? 'CAPADARE', function ($query, $parroquia) {
        //     $query->where(function ($query) use ($parroquia) {
        //         $query->where('parroquias.nombre', $parroquia);
        //     });
        // });

        $query->when($filters['sexo'] ?? null, function ($query, $sexo) {
            $query->where(function ($query) use ($sexo) {
                $query->where('personas.sexo', 'like', '%'.$sexo.'%');
            });
        });

        $query->when($filters['edad'] ?? null, function ($query, $edad) {
            $query->where(function ($query) use ($edad) {
                $query->whereRaw("(".\Carbon\Carbon::now()->format('Y').'-YEAR(personas.fecha_nacimiento)==?',[$edad]);
            });
        });

    }

    public function scopeSort($query, array $sortData)
    {   
        if($sortData){
            $query->orderBy($sortData['orderColumn']??'personas.id', $sortData['orderType']??'asc');
        }else{
            $query->orderBy('personas.id','asc');
        }
    }

    public function contacto(): HasOne
    {
        return $this->hasOne(Contacto::class);
    }
    public function miembroPsuv(): HasOne
    {
        return $this->hasOne(EstructuraPsuv::class);
    }
}
