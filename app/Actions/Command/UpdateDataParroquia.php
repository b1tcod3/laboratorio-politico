<?php

namespace App\Actions\Command;

use App\Models\DataParroquia;
use DB;
use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateDataParroquia
{
	use AsAction;
    public string $commandSignature = 'update:parroquia-data';
    public string $commandDescription = 'actualizar data de municipio';


    public function handle($tipo)
    {  
       //$data = Process\UpdateCantidadParroquias::run();
       //$data = Process\UpdateCantidadComunidadesMunicipios::run();
       //$data = Process\UpdateCantidadElectoresMunicipios::run();
       //$data = Process\Calles\UpdateCantidadCallesParroquiass::run();
       $data = Process\CentrosElectorales\UpdateCantidadCentrosElectoralesParroquia::run();
       //dd($data->toArray());

       DataParroquia::upsert(
       $data->toArray(), ['parroquia_id', 'tipo'], ['value_numeric']);
    }

public function asCommand(Command $command)
{
    //obtener la última data actualizada
    
    $data =  DataParroquia::latest()->first();

    if(true)
    {   
        $tipo = 3;
        //determinar cual data esta actualizada para actualizar
        // $check = $this->handle($data->tipo->name);
        $check = $this->handle($data->tipo->name??$tipo);
        $command->info('data Actualizada:');
    }
    else
    {
        $command->info('Fail command');
    }

}

}