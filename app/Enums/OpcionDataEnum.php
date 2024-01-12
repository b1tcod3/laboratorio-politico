<?php
  
namespace App\Enums;
 
enum OpcionDataEnum:int {

	use EnumToArray;

    case SI = 1;
    case NO = 2;

}