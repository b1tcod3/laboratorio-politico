<?php

namespace App\Actions\VotoCalle;

use Carbon\Carbon;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetVotoCalle
{
  use AsAction;

  public function handle($filters,$dataSort,$rows=10,$withPagination=1)
  { 
   $votos = DB::table('voto_calles')
   ->leftjoin('calles', 'calles.id', '=', 'voto_calles.calle_id')
   ->leftjoin('personas', 'personas.id', '=', 'voto_calles.persona_id')
   ->leftjoin('contactos', 'personas.id', '=', 'contactos.persona_id')
   ->leftjoin('personas as movilizadores', 'movilizadores.id', '=', 'voto_calles.movilizado_por_id')
   ->leftjoin('comunidads', 'comunidads.id', '=', 'calles.comunidad_id')
   ->leftjoin('centro_electorals', 'centro_electorals.id', '=', 'comunidads.centro_electoral_id')
   ->leftjoin('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
    ->leftjoin('municipios', 'municipios.id', '=', 'parroquias.municipio_id')

   ->when($filters['sexo']??null, function ($query, $sexo) {
    $query->where(function ($query) use ($sexo) {
      $query->where('personas.sexo', $sexo);
    });
  })
   ->where('calles.id',$filters['calle']??null)

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
   ->when($filters['parroquia'] ?? null, function ($query, $parroquia) {
    $query->where(function ($query) use ($parroquia) {
      $query->where('parroquias.id',$parroquia);
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
   ->select('voto_calles.id','municipio.id as municipio_id')
   ;

   if($withPagination){
    $votos = $votos->paginate($rows)
    ->withQueryString()
    ->through(fn ($voto) => [
      'id' => $voto->id,
    ]);

  }
  else{
   $votos = $votos
   ->get()
   ->transform(fn ($miembro) => [
    
  ]);
   ;
 }
 //dd($miembros);
 return $votos;
}
}