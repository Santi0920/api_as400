<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ACP03 extends Model
{
  use HasFactory;

  //Tabla que contiene toda la información de las agencias. 
  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP03';

  public function scopeAgencias($query){
  	return $query->selectRaw('RTRIM(DIST03) AS ID, RTRIM(DESC03) AS DESCRIPCION')
  			     ->where('DIST03', '>', 29)
  				 ->orderBy('DIST03', 'ASC');
  }

  //Trae una agencia por numero de centro de utilidad
  public function scopeAgencia($query, $cu){
  	return $query->selectRaw('RTRIM(DIST03) AS ID, RTRIM(DESC03) AS DESCRIPCION')
  				 ->where('DIST03', $cu);
  }
}
