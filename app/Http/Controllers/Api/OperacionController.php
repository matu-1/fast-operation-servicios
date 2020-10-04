<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OperacionController extends Controller
{

    public function generarOperacion(Request $request) // se realiza la operacion
    {
        //
    }

    function validarCadena($texto) {
      if(empty($texto)) return '';
      $cadena = str_replace(['s','S'], '5', $texto);
      $cadena = str_replace(['t', 'T'], '+', $cadena);
      $cadena = str_replace(['x', 'X'], '*', $cadena);
      $cadena = str_replace(['G'], '6', $cadena);
      return $cadena;
    }

    function existenLetras($cadena){
      $patron1 = "/^[a-zA-Z]+$/";        //solo letras
      $patron2 = "/[a-zA-Z]/";        // existe letras
      if (preg_match($patron2, $cadena)) {
        return true;
      } else {
        return false;
      }
    }
}
