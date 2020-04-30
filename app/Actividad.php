<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
  public $timestamps = false;
  protected $table = 'actividad';
  protected $attributes  = [ //defino valor por default
    'estado' => 1,
  ];
  protected $fillable = ['operacion', 'resultado', 'foto_url', 'id_usu'];

}
