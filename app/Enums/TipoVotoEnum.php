<?php
  
namespace App\Enums;
 
enum TipoVotoEnum:int {

	use EnumToArray;

    case DURO = 1;
    case BLANDO = 2;

}