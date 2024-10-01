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
            $query->where('parroquias.nombre', 'like', '%'.$search.'%');
        });

        $query->when($filters['municipio_id'] ?? null, function ($query, $municipio) {
            $query->where('parroquias.municipio_id',$municipio);
        });
        
        $query->when($filters['eje'] ?? null, function ($query, $eje) {
                $query->having('eje',$eje);
        });

        $query->when($filters['municipio'] ?? null, function ($query, $municipio) {
            $query->where('municipios.nombre', 'like', '%'.$municipio.'%');
        });
    }

    public function scopeSort($query, array $sortData)
    {   
        if($sortData){
            $query->orderBy($sortData['columnSort']??'nombre', $sortData['typeSort']??'asc');
        }else{
            $query->orderBy('nombre','asc');
        }
    }

    public function centros_electorales(): HasMany
    {
        return $this->hasMany(CentroElectoral::class);
    }

}
