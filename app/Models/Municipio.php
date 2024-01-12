<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('municipios.nombre', 'like', '%'.$search.'%')
                    ->orWhere('municipios.circuito', 'like', '%'.$search.'%')
                    ->orWhere('municipios.eje', 'like', '%'.$search.'%');
            });
        });
    }
    public function scopeSort($query, array $sortData)
    {   
        if($sortData){
            $query->orderBy($sortData['orderColumn']??'nombre', $sortData['orderType']??'asc');
        }else{
            $query->orderBy('municipios.nombre','asc');
        }
    }

    public function parroquias(): HasMany
    {
        return $this->hasMany(Parroquia::class);
    }
}
