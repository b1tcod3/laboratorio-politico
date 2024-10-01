<?php

namespace App\Actions\EstructurasPsuv;

use App\Enums\SexoEnum;
use App\Models\miembro;
use Carbon\Carbon;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMiembrosPsuvMedia
{
	use AsAction;

	public function handle($filters,$nivel,$dataSort,$rows=10,$withPagination=1)
  { 
   $miembros = DB::table('cargos')
   ->leftjoin('estructura_psuvs', 'cargos.id', '=', 'estructura_psuvs.cargo_id')
   ->leftjoin('personas', 'personas.id', '=', 'estructura_psuvs.persona_id')
   ->leftjoin('contactos', 'personas.id', '=', 'contactos.persona_id')
   ->leftjoin('municipios', 'municipios.id', '=', 'estructura_psuvs.municipio_id')
   ->leftjoin('parroquias', 'parroquias.id', '=', 'estructura_psuvs.parroquia_id')
   ->leftjoin('municipios as municipios_parroquia', 'parroquias.municipio_id', '=', 'municipios_parroquia.id')

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
   ->when($filters['municipio'] ?? null, function ($query, $municipio) {
    $query->where(function ($query) use ($municipio) {
      $query->where('municipios.id',$municipio);
    });
  })
   ->when($filters['municipio_parroquia'] ?? null, function ($query, $municipio) {
    $query->where(function ($query) use ($municipio) {
      $query->where('municipios_parroquia.id',$municipio);
    });
  })
   ->when($filters['parroquia'] ?? null, function ($query, $parroquia) {
    $query->where(function ($query) use ($parroquia) {
      $query->where('parroquias.id',$parroquia);
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
   ->select('estructura_psuvs.id','cargos.nombre as cargo_nombre','nombres','apellidos','sexo','fecha_nacimiento','personas.id as cedula','cargos.id as cargo_id','contactos.telefono_movil','municipios.nombre as municipio_nombre','municipios.id as municipio_id','municipios_parroquia.nombre as municipio_parroquia_nombre',
    'municipios_parroquia.id as municipio_parroquia_id',
    'parroquias.nombre as parroquia_nombre',
    'parroquias.id as parroquia_id'
    )
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
      'municipio_nombre' => $miembro->municipio_nombre,
      'municipio_id' => $miembro->municipio_id,
      'municipio_parroquia_nombre' => $miembro->municipio_parroquia_nombre,
      'parroquia_nombre' => $miembro->parroquia_nombre,
      'parroquia_id' => $miembro->parroquia_id,
      'municipio_parroquia_id' => $miembro->municipio_parroquia_id,
      'apellidos' => $miembro->apellidos,
      'telefono_movil' => $miembro->telefono_movil,
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