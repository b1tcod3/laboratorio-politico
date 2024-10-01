<?php

namespace App\Exports;

use App\Actions\Municipio\GetMunicipios;
use App\Models\Municipio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class MunicipiosExport implements FromCollection, WithHeadings
{	

	public function __construct($municipios) 
    {
        $this->municipios = $municipios;
        
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->municipios;
    }

    public function headings(): array
    {
        return [
            'ID',
            'EJE',
            'NOMBRE DEL MUNICIPIO',
            'CANTIDAD DE PARROQUIAS',
            'CANTIDAD DE CENTROS ELECTORALES',
        ];
    }
}
