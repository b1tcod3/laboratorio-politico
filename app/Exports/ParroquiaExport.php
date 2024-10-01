<?php

namespace App\Exports;

use App\Actions\Parroquia\GetParroquias;
use App\Models\Parroquia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ParroquiaExport implements FromCollection, WithHeadings
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
        $parroquias = GetParroquias::run($this->order, $this->filters,$this->limit,0);
        return $parroquias;
    }

    public function headings(): array
    {
        return [
            'ID',
            'EJE',
            'MUNICIPIO',
            'NOMBRE',
            'CANTIDAD DE CENTROS ELECTORES',
            'CANTIDAD DE ELECTORES'
        ];
    }
}
