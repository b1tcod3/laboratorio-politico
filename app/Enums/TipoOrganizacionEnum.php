<?php
  
namespace App\Enums;
 
enum TipoOrganizacionEnum:int {

	use EnumToArray;

    case PARTIDO_POLITICO = 1;
    case SOCIAL = 2;
    case GOBIERNO = 3;
    case MOVIMIENTO_SOCIAL = 4;
}