<?php

namespace App\Exports;

use App\Actions\CentroElectoral\GetCentrosElectorales;
use App\Models\CentroElectoral;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class CentroElectoralExport implements FromCollection,WithHeadings
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

        $centros_electorales = GetCentrosElectorales::run($this->order, $this->filters,$this->limit,0);
        return $centros_electorales;
    }

    public function headings(): array
    {
        return [
            'ID',
            'EJE',
            'MUNICIPIO',
            'PARROQUIA',
            'NOMBRE DEL CENTRO ELECTORAL',
            'ELECTORES'
        ];
    }
}
