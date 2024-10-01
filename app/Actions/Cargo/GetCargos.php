<?php

namespace App\Actions\Cargo;

use App\Enums\NivelCargoEnum;
use App\Models\Cargo;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCargos
{
    use AsAction;

    public function handle(NivelCargoEnum $nivel)
    {  
        return Cargo::where('nivel',$nivel)->get();
    }
}