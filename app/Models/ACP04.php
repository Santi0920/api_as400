<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ACP04 extends Model{
  
  use HasFactory;

  //Tabla que contiene toda la información de las nominas. 
  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP04';

  public function scopeNominas($query){
  	return $query->selectRaw('RTRIM(NOMI04) AS NOMI04, RTRIM(DESC04) AS DESCRIPCION')
  				 ->orderBy('NOMI04', 'ASC');
  }



}
