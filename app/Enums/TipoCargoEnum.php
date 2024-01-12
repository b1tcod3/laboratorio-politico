<?php
  
namespace App\Enums;
 
enum TipoCargoEnum:int {

	use EnumToArray;

    case POLITICO = 1;
    case SOCIAL = 2;
    case GOBIERNO = 3;

}