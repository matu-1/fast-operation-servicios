<?php

namespace App\Http\Controllers\Api;

use App\Actividad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActividadController extends Controller
{

    public function index() //muestra las actividades disponibles
    {
        $actividades =  Actividad::where('estado', 1)
        ->orderBy('id','asc')->get();
        return response()->json($actividades);
    }


    public function store(Request $request)
    {
        $actividad = Actividad::create($request->all()); //devuleve la nuevo instancia del modelo creado
        return response()->json([
          "ok" => true, 
          "mensaje" => "Se registro correctamente", 
          "dato" => $actividad
        ]);
    }

    public function show($id) // muestra las actividades por usuario(id)
    {
        $actividades =  Actividad::where('estado', 1)
        ->where('id_usu', $id)
         ->orderBy('id','desc')->get();
        return response()->json($actividades);
    }

    public function destroy($id)
    {
      // $resp = Actividad::destroy($id);  //devuelve 1 si lo elimino, caso contrario 0;
      // $resp = Actividad::findOrFail($id)->update(["estado" => 3]); -> no funciona
      $resp = Actividad::where('id', $id)->update(["estado" => 0]);
      if($resp){
        return response()->json(["ok" => true, "mensaje" => "Se elimino correctamente"]);
      }else {
        return response()->json(["ok" => false, "mensaje" => "No se pudo eliminar"]);
      }
    }
  
}
