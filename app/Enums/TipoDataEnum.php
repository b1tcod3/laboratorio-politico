<?php
  
namespace App\Enums;
 
enum TipoDataEnum:int {

	use EnumToArray;

    case CANTIDAD_ELECTORES = 1;
    case MILITANTE = 2;
    case CANTIDAD_COMUNIDADES = 3;
    case CANTIDAD_CALLES = 4;
    case CANTIDAD_MIEMBROS_UBCH = 5;
    case CANTIDAD_MIEMBROS_COMUNIDAD = 6;
    case CANTIDAD_MIEMBROS_CALLE = 7;
    case CANTIDAD_PARROQUIAS = 8;
    case CANTIDAD_CENTROS_ELECTORALES = 9;
    case CANTIDAD_VOTOS_CALLE = 10;
    case CANTIDAD_FAMILIAS = 11;
    case EJE = 12;
    case VOTOP_PSUV_AN_2015 = 13;
    case VOTOP_PSUV_REG_2017 = 14;
    case VOTOP_PSUV_PRES_2018 = 15;
    case VOTOP_PSUV_REG_2021 = 16;

}