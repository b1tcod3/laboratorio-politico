<?php

namespace App\Actions\Comunidad;

use App\Models\Comunidad;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateComunidad
{
    use AsAction;

    public function handle($data)
    {  
        $comunidad = Comunidad::create([
         'centro_electoral_id' => $data['centro_electoral'],
         'nombre' => $data['nombre'],
		]);

        return $comunidad;
    }
}