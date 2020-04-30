<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
  public function login(Request $request)
  {
      $usuario=DB::table('users')->where('email','=',$request->email)->where('estado', 1)->first();
      if($usuario!=null){
          if(Hash::check($request->password, $usuario->password)){ //verifica si la contrasena es correcta o no
              return response()->json(["ok" => true, 'mensaje' => "Se logeo correctamente", 'datos' => $usuario]);
          }else{
              return response()->json(["ok" => false, 'mensaje' => "Contraseña incorrecta"]);
          }
      }else{
          return response()->json(["ok" => false, 'mensaje' => "No existe usuario"]);
      }
  }

  
  public function store(Request $request)
    { 
        $usuario = User::where("email", $request->email)->first(); 
        if($usuario)return response()->json(["ok" => false, "mensaje" => "EL email ya esta registrado"]); //si existe
        $usuario = User::create($request->all()); //devuleve la nuevo instancia del modelo creado
        return response()->json([
          "ok" => true, 
          "mensaje" => "Se registro correctamente", 
          "datos" => $usuario
        ]);
    }
}
