<?php

namespace App\Actions\User;

use App\Models\AccesoUser;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUsers
{
	use AsAction;

	public function handle($order,$filters,$rows=10,$withPagination=1)
    { 
        
        $filters['estructura'] = $filters['estructura']??'';

        $users = AccesoUser::join('users', 'users.id', '=', 'acceso_users.user_id')
            ->when($filters['estructura']=='estructura_psuvs', function ($query, $search) {
            $query->whereNotNull('estructura_psuv_id');
            })
            ->when($filters['estructura']=='institucion', function ($query, $search) {
            $query->whereNotNull('estructura_institucion_id');
            })
            ->when($filters['estructura']=='movimiento', function ($query, $search) {
            $query->whereNotNull('estructura_movimiento_social_id');
            })
            ->select('users.id','users.name');
        
        if($withPagination){
            $users = $users->paginate($rows)
            ->withQueryString()
            ->through(fn ($user) => [
              'id' => $user->id,
              'username' => $user->name,
            ]);
        }
        else{
             $users = $users->get();
        }
        return $users;
    }
}