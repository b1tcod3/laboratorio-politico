<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    use HasFactory;

    public function centro_electoral(): BelongsTo
    {
        return $this->belongsTo(CentroElectoral::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('comunidads.nombre', 'like', '%' . $search . '%')
                    ->orWhere('comunidads.id', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['municipio'] ?? null, function ($query, $municipio) {
            $query->where(function ($query) use ($municipio) {
                $query->where('comunidads.municipio_id', $municipio);
            });
        });

        $query->when($filters['municipio_eje'] ?? null, function ($query, $municipio_eje) {
            $query->having('eje', $municipio_eje);
        });

        $query->when($filters['parroquia'] ?? null, function ($query, $parroquia) {
            $query->where('comunidads.parroquia_id', $parroquia);
        });

        $query->when($filters['centro_electoral_id'] ?? null, function ($query, $centro_electoral) {
            $query->where('comunidads.centro_electoral_id', $centro_electoral);
        });

    }

    public function scopeSort($query, array $sortData)
    {
        if ($sortData) {
            $query->orderBy($sortData['orderColumn'] ?? 'comunidads.nombre', $sortData['orderType'] ?? 'asc');
        } else {
            $query->orderBy('nombre', 'asc');
        }
    }
}
