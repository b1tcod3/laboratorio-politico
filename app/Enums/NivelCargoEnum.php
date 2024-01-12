<?php
  
namespace App\Enums;
 
enum NivelCargoEnum:int {

	use EnumToArray;

	//PARTIDO
    case EPR = 1;
    case EPM = 2;
    case EPP = 3;
    case UBCH= 4;
    case COMUNIDAD = 5;
    case CALLE = 6;
   	
    case SOCIAL = 11;
    case GOBIERNO = 21;

}