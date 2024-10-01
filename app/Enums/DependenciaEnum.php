<?php
  
namespace App\Enums;
 
enum DependenciaEnum:int {

	use EnumToArray;

    case MINISTERIO = 1;
    case GOBERNACION = 2;
    case ALCALDIA = 3;
}