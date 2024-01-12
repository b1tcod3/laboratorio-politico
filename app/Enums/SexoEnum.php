<?php
  
namespace App\Enums;
 
enum SexoEnum:int {

	use EnumToArray;

    case F = 1;
    case M = 2;
}