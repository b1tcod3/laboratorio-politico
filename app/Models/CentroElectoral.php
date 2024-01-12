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
                ->orWhere('municipios.nombre', 'like', '%'.$search.'%')
                ->orWhere('municipios.eje', 'like', '%'.$search.'%')
                ->orWhere('centro_electorals.id', 'like', '%'.$search.'%');
            });
        });

        $query->when($filters['municipio'] ?? null, function ($query, $municipio) {
            $query->where(function ($query) use ($municipio) {
                $query->where('municipios.nombre', 'like', '%'.$municipio.'%');
            });
        });

        $query->when($filters['parroquia'] ?? null, function ($query, $parroquia) {
            $query->where(function ($query) use ($parroquia) {
                $query->where('parroquias.nombre', 'like', '%'.$parroquia.'%');
            });
        });

        $query->when($filters['eje'] ?? null, function ($query, $eje) {
            $query->where(function ($query) use ($eje) {
                $query->where('municipios.eje', 'like', '%'.$eje.'%');
            });
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
