<?php

namespace App\Actions\Command;

use App\Models\DataComunidad;
use DB;
use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateDataComunidad
{
	use AsAction;
    public string $commandSignature = 'update:comunidad-data';
    public string $commandDescription = 'actualizar data de comunidad';


    public function handle($tipo)
    {  
       $data = Process\UpdateCantidadMiembrosPsuvComunidad::run();

       //dd($data->toArray());

       DataComunidad::upsert(
       $data->toArray(), ['comunidad_id', 'tipo'], ['value_numeric']);
    }

public function asCommand(Command $command)
{
    //obtener la última data actualizada
    
    $data =  DataComunidad::latest()->first();

    if(true)
    {   
        $tipo = 6;
        //determinar cual data esta actualizada para actualizar
        // $check = $this->handle($data->tipo->name);
        //$check = $this->handle($data->tipo->name??$tipo);
        $check = $this->handle($tipo);
        //$command->info('data Actualizada:'.$data->tipo->name);
        $command->info('data Actualizada:');
    }
    else
    {
        $command->info('Fail command');
    }

}

}