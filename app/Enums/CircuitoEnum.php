<?php
  
namespace App\Enums;
 
enum CircuitoEnum:int {

	use EnumToArray;

    case SIERRA_OCCIDENTE = 1;
    case LOS_TAQUES_CARIRUBANA = 2;
    case FALCON_MIRANDA = 3;
    case COSTA = 4;
}