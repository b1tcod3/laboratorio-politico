<?php

namespace App\Actions\EstructurasPsuv;

use App\Enums\SexoEnum;
use App\Models\miembro;
use Carbon\Carbon;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMiembrosPsuvBase
{
	use AsAction;

	public function handle($filters,$nivel,$dataSort,$rows=10,$withPagination=1)
  { 
   $miembros = DB::table('cargos')
   ->leftjoin('estructura_psuvs', 'cargos.id', '=', 'estructura_psuvs.cargo_id')
   ->leftjoin('personas', 'personas.id', '=', 'estructura_psuvs.persona_id')
   ->leftjoin('contactos', 'personas.id', '=', 'contactos.persona_id')
   ->leftjoin('centro_electorals', 'centro_electorals.id', '=', 'estructura_psuvs.centro_electoral_id')
   ->leftjoin('parroquias as parroquia_centro_electorals', 'parroquia_centro_electorals.id', '=', 'centro_electorals.parroquia_id')
    ->leftjoin('municipios as municipio_centro_electorals', 'municipio_centro_electorals.id', '=', 'parroquia_centro_electorals.municipio_id')

   ->when($filters['sexo']??null, function ($query, $sexo) {
    $query->where(function ($query) use ($sexo) {
      $query->where('personas.sexo', $sexo);
    });
  })
   ->where('cargos.nivel',$nivel)

   ->when($dataSort ?? null, function ($query, $dataSort) {

    $query->orderBy($dataSort['orderColumn']??'id', $dataSort['orderType']??'asc');
  })
   ->when($filters['nombres'] ?? null, function ($query, $search) {
    $query->where(function ($query) use ($search) {
      $query->where('personas.nombres', 'like', '%'.$search.'%');
    });
  })
   ->when($filters['municipio_centro_electoral'] ?? null, function ($query, $municipio) {
    $query->where(function ($query) use ($municipio) {
      $query->where('municipio_centro_electorals.id',$municipio);
    });
  })
   ->when($filters['parroquia_centro_electoral'] ?? null, function ($query, $parroquia) {
    $query->where(function ($query) use ($parroquia) {
      $query->where('parroquia_centro_electorals.id',$parroquia);
    });
  })
   ->when($filters['centro_electorals'] ?? null, function ($query, $centro_electoral) {
    $query->where(function ($query) use ($centro_electoral) {
      $query->where('centro_electorals.id',$centro_electoral);
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
   ->select('estructura_psuvs.id','cargos.nombre as cargo_nombre','nombres','apellidos','sexo','fecha_nacimiento','personas.id as cedula','cargos.id as cargo_id','contactos.telefono_movil','municipio_centro_electorals.nombre as nombre_municipio_centro_electoral','municipio_centro_electorals.id as id_municipio_centro_electoral','municipio_centro_electorals.nombre as nombre_municipio_centro_electoral','municipio_centro_electorals.id as id_municipio_centro_electoral')
   ;

   if($withPagination){
    $miembros = $miembros->paginate($rows)
    ->withQueryString()
    ->through(fn ($miembro) => [
      'id' => $miembro->id,
      'cedula' => $miembro->cedula,
      'cargo_nombre' => $miembro->cargo_nombre,
      'nombres' => $miembro->nombres,
      'cargo_id' => $miembro->cargo_id,
      'apellidos' => $miembro->apellidos,
      'telefono_movil' => $miembro->telefono_movil,
      'nombre_municipio_centro_electoral' => $miembro->nombre_municipio_centro_electoral,
      'nombre_parroquia_centro_electoral' => $miembro->nombre_municipio_centro_electoral,
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
    'cargo_id' => $miembro->cargo_id,
    'telefono_movil' => $miembro->telefono_movil,
    'sexo' => SexoEnum::from($miembro->sexo)->name,
    'edad' => Carbon::parse($miembro->fecha_nacimiento)->age,
  ]);
   ;
 }
 //dd($miembros);
 return $miembros;
}
}