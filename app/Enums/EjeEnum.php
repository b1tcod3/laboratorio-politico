<?php
  
namespace App\Enums;

enum EjeEnum:string {

	use EnumToArray;

    case CAPITAL = 'Centro';
    case OCCIDENTE = 'Occidente';
    case SIERRA = 'Sierra';
    case COSTA = 'Costa';
    case PARAGUANA = 'Paraguaná';
}