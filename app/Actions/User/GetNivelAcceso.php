<?php

namespace App\Actions\User;

use App\Models\User;
use App\Enums\TipoEstructuraEnum;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNivelAcceso
{
	use AsAction;

	public function handle(User $user)
    { 

       $is_admin = $user->admin;

       if(!$is_admin)
       {
            $miembro_psuv = $user->acceso->miembro_psuv;
            $miembro_institucion = $user->acceso->miembro_institucion;
            $miembro_movimiento_social = $user->acceso->miembro_movimiento_social;

            if($miembro_psuv){
                $acceso = ['estructura'=>TipoEstructuraEnum::PSUV,
                'municipio'=>$miembro_psuv->municipio
            ];
            }
            if($miembro_institucion){
            $acceso = ['estructura'=>TipoEstructuraEnum::INSTITUCION,
            'municipio'=>$miembro_institucion->municipio
            ];
            }
            if($miembro_movimiento_social){
                $acceso = ['estructura'=>TipoEstructuraEnum::MOVIMIENTO_SOCIAL,
                'municipio'=>$miembro_movimiento_social->municipio
            ];
            }
        }
else{

    $acceso = [
        'estructura'=>'admin',
        'municipio'=>null
    ];
}

return $acceso;

}
}