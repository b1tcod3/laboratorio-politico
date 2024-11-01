<?php
namespace App\Http\Controllers;

use App\Models\Municipio;
use App\Models\Parroquia;

class ApiController extends Controller
{
    public function municipios()
    {
        return Municipio::all();
    }

    public function parroquias($municipio)
    {
        return Parroquia::filter(['municipio_id' => $municipio])
            ->orderBy('nombre')
            ->get();
    }

}
