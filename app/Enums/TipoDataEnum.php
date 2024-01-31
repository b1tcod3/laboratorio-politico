<?php
  
namespace App\Enums;
 
enum TipoDataEnum:int {

	use EnumToArray;

    case CANTIDAD_ELECTORES = 1;
    case MILITANTE = 2;
    case CANTIDAD_COMUNIDADES = 3;
    case CANTIDAD_CALLES = 4;
    case CANTIDAD_MIEMBROS_UBCH = 5;
    case CANTIDAD_MIEMBROS_COMUNIDAD = 6;
    case CANTIDAD_MIEMBROS_CALLE = 7;
}