<?php
namespace App\Actions\Command;

use App\Models\DataMunicipio;
use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateDataMunicipio
{
    use AsAction;
    public string $commandSignature   = 'update:municipio-data';
    public string $commandDescription = 'actualizar data de municipio';

    public function handle($tipo)
    {
        //CANTIDAD DE PARROQUIA. FIJO. PRUEBA
        $data = Process\Parroquias\UpdateCantidadParroquiasMunicipio::run();

        //CANTIDAD DE CENTROS ELECTORALES
        //$data = Process\CentrosElectorales\UpdateCantidadCentrosElectoralesMunicipios::run();

        // $data = Process\Comunidades\UpdateCantidadComunidadesMunicipios::run();
        //$data = Process\Electores\UpdateCantidadElectoresMunicipios::run();
        //$data = Process\Calles\UpdateCantidadCallesMunicipios::run();
        //$data = Process\CentrosElectorales\UpdateCantidadCentrosElectoralesMunicipios::run();
        //dd($data->toArray());

        DataMunicipio::upsert(
            $data->toArray(), ['municipio_id', 'tipo'], ['value_numeric']);
    }

    public function asCommand(Command $command)
    {
        //obtener la última data actualizada

        $data = DataMunicipio::latest()->first();

        if (true) {
            $tipo = 3;
            //determinar cual data esta actualizada para actualizar
            // $check = $this->handle($data->tipo->name);
            $check = $this->handle($data->tipo->name ?? $tipo);
            $command->info('data Actualizada:');
        } else {
            $command->info('Fail command');
        }

    }

}
