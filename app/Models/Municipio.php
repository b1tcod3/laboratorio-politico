<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('municipios.nombre', 'like', '%'.$search.'%');
        });

        $query->when($filters['eje'] ?? null, function ($query, $eje) {
                $query->having('eje',$eje);
        });

    }
    public function scopeSort($query, array $sortData)
    {   
        if($sortData){
            $query->orderBy($sortData['columnSort']??'nombre', $sortData['typeSort']??'asc');
        }else{
            $query->orderBy('municipios.nombre','asc');
        }
    }

    public function parroquias(): HasMany
    {
        return $this->hasMany(Parroquia::class);
    }

    public function scopeEje()
    {
            return \App\Enums\EjeEnum::from($this->hasOne(DataMunicipio::class)->where('tipo',\App\Enums\TipoDataEnum::EJE)->first()->value_enum)->name;
    }
}
