<?php
  
namespace App\Enums;
 
enum TipoDataEnum:int {

	use EnumToArray;

    case CANTIDAD_ELECTORES = 1;
    case MILITANTE = 2;
}