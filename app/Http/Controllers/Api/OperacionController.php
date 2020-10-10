<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Response;
use Aws\Rekognition\RekognitionClient;   /// este es el servicio utilizado de IA
ini_set('max_execution_time', 120); //2 minutes

class OperacionController extends Controller
{

    public function generarOperacion(Request $request) // se realiza la operacion
    {
      $imagen = $request->foto;
      $path = "images";
      $path = $path."/".rand()."_".time().".jpeg";    
      $img = str_replace('data:image/jpeg;base64,', '', $imagen);
      $img = str_replace(' ', '+', $img);
      if(file_put_contents(public_path().'/'.$path, base64_decode($img))){

        $client = new RekognitionClient([
            'version' => 'latest',
            'region'  => 'us-west-2',
            'credentials' => [
                'key' => 'AKIAUZ7DNBSK3G6US5EO',
                'secret' => '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'
            ]
        ]);
        
        $target_dir =  $path;
        $result = $client->detectText([
            'Image' => [ // REQUIRED
                'Bytes' =>file_get_contents($target_dir),
            ]
        ]);
        $datos = $result["TextDetections"];  ///   ( 5 + 5 ) / 5
        $texto = $datos[0]["DetectedText"];
        $texto = $this->validarCadena($texto);
        $resul = '';
        try {
          if($this->existenLetras($texto)) throw new Exception('No tienen que ser letras');    
          eval('$resul = '."$texto;");/// 1 + 5
          return response([
            "ok" => true,
            "mensaje" => "se genero correctamente la operacion",
            "datos" => [
              "operacion" => $texto,
              "resultado" => $resul.'',
              "foto_url" => $path,
            ],
          ]);
        } catch (\Throwable $th) {
          return response([
            "ok" => false,
            "mensaje" => "No es posible realizar la operacion",
            "texto" => $texto,
          ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

      }else {
        return response([
          "ok" => false,
          "mensaje" => "No es posible procesar la imagen",
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }

    public function validarCadena($texto) {
      if(empty($texto)) return '';
      $cadena = str_replace(['s','S'], '5', $texto);
      $cadena = str_replace(['t', 'T'], '+', $cadena);
      $cadena = str_replace(['x', 'X'], '*', $cadena);
      $cadena = str_replace(['G'], '6', $cadena);
      return $cadena;
    }

    public function existenLetras($cadena){
     // $patron1 = "/^[a-zA-Z]+$/";        //solo letras
      $patron2 = "/[a-zA-Z]/";        // existe letras
      if (preg_match($patron2, $cadena)) {
        return true;
      } else {
        return false;
      }
    }
}
