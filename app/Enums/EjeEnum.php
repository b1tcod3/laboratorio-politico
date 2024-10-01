<?php
  
namespace App\Enums;

enum EjeEnum:int {

	use EnumToArray;

    case CENTRO = 1;
    case OCCIDENTE = 2;
    case SIERRA = 3;
    case COSTA = 4;
    case PARAGUANA = 5;
}