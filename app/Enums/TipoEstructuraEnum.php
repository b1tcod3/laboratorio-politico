<?php
  
namespace App\Enums;
 
enum TipoEstructuraEnum:int {

	use EnumToArray;

    case PSUV = 1;
    case INSTITUCION = 2;
    case MOVIMIENTO_SOCIAL = 3;

}