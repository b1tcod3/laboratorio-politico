<?php
namespace App\Enums;

enum NivelEstructuraEnum: int {
	
	use EnumToArray;
    case REGIONAL        = 1;
    case MUNICIPAL       = 2;
    case PARROQUIAL      = 3;
    case UBCH            = 4;
    case COMUNIDAD       = 5;
    case CALLE           = 6;
    case COMUNAL         = 7;
    case CONSEJO_COMUNAL = 8;
}
