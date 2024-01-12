<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parroquia extends Model
{
    use HasFactory;

    /**
     * el municipio de la parroquia
     */
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('parroquias.nombre', 'like', '%'.$search.'%')
                    ->orWhereHas('municipio', function ($query) use ($search) {
                        $query->where('nombre', 'like', '%'.$search.'%')
                        ->orWhere('circuito', 'like', '%'.$search.'%')
                    	->orWhere('eje', 'like', '%'.$search.'%');
                    });
            });
        });

        $query->when($filters['municipio'] ?? null, function ($query, $municipio) {
            $query->where(function ($query) use ($municipio) {
                $query->WhereHas('municipio', function ($query) use ($municipio) {
                        $query->where('nombre', $municipio);
                    });
                    ;
            });
        });
        $query->when($filters['eje'] ?? null, function ($query, $eje) {
            $query->where(function ($query) use ($eje) {
                $query->WhereHas('municipio', function ($query) use ($eje) {
                        $query->where('eje', $eje);
                    });
                    ;
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

    public function centros_electorales(): HasMany
    {
        return $this->hasMany(CentroElectoral::class);
    }

}
