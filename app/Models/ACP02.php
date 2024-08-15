<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ACP02 extends Model{
  
  use HasFactory;

  //Tabla que contiene toda la información de las dependencias. 
  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP02';

  public function scopeDependencias($query, $id_nomina){
  	return $query->selectRaw('RTRIM(ENTI02) AS ID, RTRIM(DESC02) AS DESCRIPCION, RTRIM(NOMI02) AS ID_NOMI, RTRIM(DEPE02) AS CODDEPENDENCIA')
  				 ->where('NOMI02', $id_nomina);
  }

  public function scopeNomina($query, $nomina){
    return $query->selectRaw('RTRIM(NOMI04) AS CODNOMINA,
                RTRIM(DESC04) AS NONNOMINA,
                RTRIM(DEPE02) AS CODDEPENDENCIA,
                RTRIM(DESC02) AS NOMDEPEDENCIA,
                RTRIM(ENTI02) AS ENTIDAD')
                ->join('COLIB.ACP04', 'COLIB.ACP02.NOMI02', '=', 'COLIB.ACP04.NOMI04')
                ->where('COLIB.ACP04.NOMI04', $nomina);
  }

}
