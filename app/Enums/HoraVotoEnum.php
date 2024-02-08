<?php
  
namespace App\Enums;
 
enum HoraVotoEnum:String {

	use EnumToArray;

    case H1 = 1;
    case H2 = 2;
    case H3 = 3;
    
}