<?php

namespace App\Actions\User;

use App\Models\AccesoUser;
use App\Models\Persona;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Hash;

class CreateAccesoUser
{
  use AsAction;

  public function handle($data)
  {  
    $persona = Persona::findOrFail($data['cedula']);

    $persona->contacto()->update([
     "telefono_movil" => $data["telefono_movil"]??null,
     "telefono_movil_aux" =>$data["telefono_movil_aux"]??null,
     "email" => $data["email"]
   ]);

 try { 

  DB::beginTransaction();   
        //crear usuario
    $user = User::create([
      'name' =>  $persona->nombres." ".$persona->apellidos,
      'email' =>  $data["email"],
      'password' => Hash::make($data["password"]),
    ]); 

    $acceso_user = AccesoUser::create([
     'user_id' => $user->id,
     'estructura_institucion_id' => $data['estructura_institucion']??null,
     'estructura_psuv_id' => $data['estructura_psuv']??null,
     'estructura_movimiento_social_id' => $data['estructura_movimiento_social']??null,

   ]);

  DB::commit();
}
catch (\Exception $e) {

// An error occured; cancel the transaction...

DB::rollback();

// and throw the error again.

throw $e;

}


    return $acceso_user;
  }
}