<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ACP23 extends Model {
  
  use HasFactory;

  //Esta tabla contiene la mayor parte de información de los asociados 
  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP23';

  public function scopeEstado($query, $cuenta, $linea, $capital){
    return $query->selectRaw('RTRIM(TCRE23) AS EMPRESA,
                  RTRIM(CAPI23) AS CAPITAL,
                  RTRIM(STAT23) AS ESTADO')
                 ->where('COLIB.ACP23.NCTA23', $cuenta)
                 ->where('COLIB.ACP23.CAPI23', $capital)
                 ->where(function($query) {
                  $query->where('COLIB.ACP23.STAT23', '=', '0')
                        ->orWhere('COLIB.ACP23.STAT23', '=', '1');
                  })
                 ->where('COLIB.ACP23.TCRE23', $linea);
  }
}
