<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calle extends Model
{
    use HasFactory;

    public function comunidad(): BelongsTo
    {
        return $this->belongsTo(Comunidad::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('calles.nombre', 'like', '%' . $search . '%')
                    ->orWhere('calles.id', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['municipio'] ?? null, function ($query, $municipio) {
            $query->where(function ($query) use ($municipio) {
                $query->where('calles.municipio_id', $municipio);
            });
        });

        $query->when($filters['municipio_eje'] ?? null, function ($query, $municipio_eje) {
            $query->having('eje', $municipio_eje);
        });

        $query->when($filters['parroquia'] ?? null, function ($query, $parroquia) {
            $query->where('calles.parroquia_id', $parroquia);
        });

        $query->when($filters['centro_electoral_id'] ?? null, function ($query, $centro_electoral) {
            $query->where('calles.centro_electoral_id', $centro_electoral);
        });

    }

    public function scopeSort($query, array $sortData)
    {
        if ($sortData) {
            $query->orderBy($sortData['orderColumn'] ?? 'calles.nombre', $sortData['orderType'] ?? 'asc');
        } else {
            $query->orderBy('nombre', 'asc');
        }
    }
}
