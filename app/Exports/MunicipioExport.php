<?php

namespace App\Exports;

use App\Actions\Municipio\GetMunicipios;
use App\Models\Municipio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class MunicipioExport implements FromCollection, WithHeadings
{	

	public function __construct($filters=[],$sort=[], $limit=10) 
    {
        $this->filters = $filters;
        $this->order = $sort;
        $this->limit = $limit;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $municipios = GetMunicipios::run($this->order, $this->filters,$this->limit,0);
        return $municipios;
    }

    public function headings(): array
    {
        return [
            'ID',
            'EJE',
            'NOMBRE DEL MUNICIPIO',
            'CIRCUITO',
            'CANTIDAD DE PARROQUIAS',
            'CANTIDAD DE CENTROS ELECTORALES',
            'CANTIDAD DE ELECTORES'
        ];
    }
}
