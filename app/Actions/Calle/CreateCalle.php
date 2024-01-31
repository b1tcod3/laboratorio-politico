<?php

namespace App\Actions\Calle;

use App\Models\Calle;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCalle
{
    use AsAction;

    public function handle($data)
    {  
        $calle = Calle::create([
         'comunidad_id' => $data['comunidad'],
         'nombre' => $data['nombre'],
		]);

        return $calle;
    }
}