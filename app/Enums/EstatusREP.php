<?php
  
namespace App\Enums;
 
enum EstatusREP:int {

	use EnumToArray;

    case NUEVO_REGISTRO = 1;
    case CAMBIO_RESIDENCIA = 2;
    case PROBLEMA_DATOS = 3;
    case MENOR_EDAD = 4;

}