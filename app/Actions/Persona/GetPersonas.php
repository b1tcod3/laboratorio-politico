<?php

namespace App\Actions\Persona;

use App\Enums\SexoEnum;
use App\Models\Persona;
use Carbon\Carbon;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPersonas
{
	use AsAction;

	public function handle($filters,$rows=10,$withPagination=1)
    { 
       $personas = DB::table('personas')->leftjoin('electores', 'personas.id', '=', 'electores.persona_id')
       ->leftjoin('centro_electorals', 'centro_electorals.id', '=', 'electores.centro_electoral_id')
       ->leftjoin('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
       ->leftjoin('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
       ->when($filters['parroquia']??101, function ($query, $municipio) {
            $query->where(function ($query) use ($municipio) {
                $query->where('parroquias.id', $municipio);
            });
        })
       ->when($filters['sexo']??null, function ($query, $sexo) {
            $query->where(function ($query) use ($sexo) {
                $query->where('personas.sexo', $sexo);
            });
        })
       ->when($filters['centro_electoral']??null, function ($query, $centro_electoral) {
            $query->where(function ($query) use ($centro_electoral) {
                $query->where('centro_electorals.id', $centro_electoral);
            });
        })
       ->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('personas.nombres', 'like', '%'.$search.'%')
                ->orWhere('personas.apellidos', 'like', '%'.$search.'%')
                ->orWhere('personas.id', 'like', '%'.$search.'%');
            });
        })
       ->select('personas.id','nombres','apellidos','sexo','fecha_nacimiento',DB::Raw('municipios.nombre as municipio,parroquias.nombre as parroquia,centro_electorals.nombre as centro_electoral'))
       ;

       if($withPagination){
        $personas = $personas->paginate($rows)
        ->withQueryString()
        ->through(fn ($persona) => [
            'id' => $persona->id,
            'nombres' => $persona->nombres,
            'apellidos' => $persona->apellidos,
            'sexo' => SexoEnum::from($persona->sexo)->name,
            'fecha_nacimiento' => Carbon::parse($persona->fecha_nacimiento)->isoformat('DD/MM/Y'),
            'edad' => Carbon::parse($persona->fecha_nacimiento)->age,
            'municipio' => $persona->municipio,
            'parroquia' => $persona->parroquia,
            'centro_electoral' => $persona->centro_electoral,
        ]);

    }
    else{
       $personas = $personas
       ->get()
       ->transform(fn ($persona) => [
        'id' => $persona->id,
            'nombres' => $persona->nombres,
            'apellidos' => $persona->apellidos,
            'sexo' => SexoEnum::from($persona->sexo)->name,
            'fecha_nacimiento' => Carbon::parse($persona->fecha_nacimiento)->isoformat('DD/MM/Y'),
            'edad' => Carbon::parse($persona->fecha_nacimiento)->age,
            'municipio' => $persona->municipio,
            'parroquia' => $persona->parroquia,
            'centro_electoral' => $persona->centro_electoral,
    ]);
       ;
   }
   return $personas;
}
}