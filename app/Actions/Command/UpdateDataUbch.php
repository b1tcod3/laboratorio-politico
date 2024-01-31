<?php

namespace App\Actions\Command;

use App\Models\DataCentroElectoral;
use DB;
use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateDataUbch
{
	use AsAction;
    public string $commandSignature = 'update:ubch-data';
    public string $commandDescription = 'actualizar data de ubch';


    public function handle($tipo)
    {  
       $data = Process\UpdateCantidadComunidadesUbch::run();

       //dd($data->toArray());

       DataCentroElectoral::upsert(
       $data->toArray(), ['centro_electoral_id', 'tipo'], ['value_numeric']);
    }

public function asCommand(Command $command)
{
    //obtener la última data actualizada
    
    $data =  DataCentroElectoral::latest()->first();

    if($data)
    {   
        $tipo = 3;
        //determinar cual data esta actualizada para actualizar
        // $check = $this->handle($data->tipo->name);
        $check = $this->handle($data->tipo->name??$tipo);
        $command->info('data Actualizada:'.$data->tipo->name);
    }
    else
    {
        $command->info('Fail command');
    }

}

}