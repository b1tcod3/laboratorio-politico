<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CentroElectoral extends Model
{
    use HasFactory;

    public function parroquia(): BelongsTo
    {
        return $this->belongsTo(Parroquia::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('centro_electorals.nombre', 'like', '%'.$search.'%')
                ->orWhere('centro_electorals.id', 'like', '%'.$search.'%');
            });
        });

        $query->when($filters['municipio'] ?? null, function ($query, $municipio) {
            $query->where(function ($query) use ($municipio) {
                $query->where('municipios.id', $municipio);
            });
        });
        $query->when($filters['municipio_eje'] ?? null, function ($query, $municipio_eje) {
            $query->where(function ($query) use ($municipio_eje) {
                $query->where('data_municipios.value_enum', $municipio_eje);
            });
        });

        $query->when($filters['parroquia'] ?? null, function ($query, $parroquia) {
            $query->where('parroquias.id',$parroquia);
        });
        $query->when($filters['centro_electoral'] ?? null, function ($query, $centro_electoral) {
            $query->where('centro_electorals.id',$centro_electoral);
        });

        

    }

    public function scopeSort($query, array $sortData)
    {   
        if($sortData){
            $query->orderBy($sortData['orderColumn']??'nombre', $sortData['orderType']??'asc');
        }else{
            $query->orderBy('nombre','asc');
        }
    }
}
