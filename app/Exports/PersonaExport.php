<?php

namespace App\Exports;

use App\Actions\Persona\GetPersonas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PersonaExport implements FromCollection, WithHeadings
{	

	public function __construct($filters=[], $limit=10) 
    {
        $this->filters = $filters;
        $this->limit = $limit;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $personas = GetPersonas::run($this->filters,$this->limit,0);
        return $personas;
    }

    public function headings(): array
    {
        return [
            'ID',
            'NOMBRES',
            'APELLIDOS',
            'SEXO',
            'FECHA NACIMIENTO',
            'EDAD',
            'MUNICIPIO',
            'PARROQUIA'
        ];
    }
}
