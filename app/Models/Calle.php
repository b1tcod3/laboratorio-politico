<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Calle extends Model
{
    use HasFactory;

    protected $fillable = [
        'comunidad_id',
        'nombre'
    ];

    public function comunidad(): BelongsTo
    {
        return $this->belongsTo(Comunidad::class);
    }

    public function miembros_psuv(): HasMany
    {
        return $this->hasMany(EstructuraPsuv::class,'calle_id');
    }

    // para los votos
    // public function calles(): HasMany
    // {
    //     return $this->hasMany(Calle::class);
    // }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('calles.nombre', 'like', '%'.$search.'%');
            });
        });

        $query->when($filters['municipio'] ?? null, function ($query, $municipio) {
            $query->where(function ($query) use ($municipio) {
                $query->where('municipios.id',$municipio);
            });
        });

        $query->when($filters['parroquia'] ?? null, function ($query, $parroquia) {
            $query->where(function ($query) use ($parroquia) {
                $query->where('parroquias.id',$parroquia);
            });
        });
        $query->when($filters['centro_electoral'] ?? null, function ($query, $centro_electoral) {
            $query->where(function ($query) use ($centro_electoral) {
                $query->where('centro_electorals.id',$centro_electoral);
            });
        });

        $query->when($filters['comunidad'] ?? null, function ($query, $comunidad) {
            $query->where(function ($query) use ($comunidad) {
                $query->where('comunidads.id',$comunidad);
            });
        });

        $query->when($filters['calles'] ?? null, function ($query, $calle) {
            $query->where(function ($query) use ($calle) {
                $query->where('calles.id',$calle);
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
            $query->orderBy($sortData['orderColumn']??'calles.nombre', $sortData['orderType']??'asc');
        }else{
            $query->orderBy('calles.nombre','asc');
        }
    }
}
