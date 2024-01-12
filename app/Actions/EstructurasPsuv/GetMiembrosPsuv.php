<?php

namespace App\Actions\EstructurasPsuv;

use App\Enums\SexoEnum;
use App\Models\miembro;
use Carbon\Carbon;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMiembrosPsuv
{
	use AsAction;

	public function handle($filters,$nivel,$rows=10,$withPagination=1)
  { 
   $miembros = DB::table('cargos')
   ->leftjoin('estructura_psuvs', 'cargos.id', '=', 'estructura_psuvs.cargo_id')
   ->leftjoin('personas', 'personas.id', '=', 'estructura_psuvs.persona_id')
   ->when($filters['sexo']??null, function ($query, $sexo) {
    $query->where(function ($query) use ($sexo) {
      $query->where('personas.sexo', $sexo);
    });
  })
   ->where('cargos.nivel',$nivel)

   ->when($filters['nombres'] ?? null, function ($query, $search) {
    $query->where(function ($query) use ($search) {
      $query->where('personas.nombres', 'like', '%'.$search.'%');
    });
  })
   ->when($filters['apellidos'] ?? null, function ($query, $search) {
    $query->where(function ($query) use ($search) {
      $query->where('personas.apellidos', 'like', '%'.$search.'%');
    });
  })
   ->when($filters['cedula'] ?? null, function ($query, $cedula) {
    $query->where(function ($query) use ($cedula) {
      $query->where('personas.id', 'like', '%'.$cedula.'%');
    });
  })
   ->select('estructura_psuvs.id','cargos.nombre as cargo_nombre','nombres','apellidos','sexo','fecha_nacimiento','personas.id as cedula')
   ;

   if($withPagination){
    $miembros = $miembros->paginate($rows)
    ->withQueryString()
    ->through(fn ($miembro) => [
      'id' => $miembro->id,
      'cedula' => $miembro->cedula,
      'cargo_nombre' => $miembro->cargo_nombre,
      'nombres' => $miembro->nombres,
      'apellidos' => $miembro->apellidos,
      'sexo' => SexoEnum::from($miembro->sexo==''?1:$miembro->sexo)->name,
      'edad' => Carbon::parse($miembro->fecha_nacimiento)->age,

    ]);

  }
  else{
   $miembros = $miembros
   ->get()
   ->transform(fn ($miembro) => [
    'id' => $miembro->id,
    'cedula' => $miembro->cedula,
    'cargo_nombre' => $miembro->cargo_nombre,
    'nombres' => $miembro->nombres,
    'apellidos' => $miembro->apellidos,
    'sexo' => SexoEnum::from($miembro->sexo)->name,
    'edad' => Carbon::parse($miembro->fecha_nacimiento)->age,
  ]);
   ;
 }
 //dd($miembros);
 return $miembros;
}
}