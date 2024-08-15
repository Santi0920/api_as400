<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ACP26 extends Model {
  
  use HasFactory;

  //Esta tabla contiene la mayor parte de información de los asociados 
  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP26';

  public function scopeGarantia($query, $pagare, $cuenta){
    return $query->selectRaw('RTRIM(NCTA26) AS CUENTA,
                RTRIM(NCRE26) AS PAGARE,
                RTRIM(MOGA26) AS GARANTIA')
                 ->where('COLIB.ACP26.NCTA26', $cuenta)
                 ->where('COLIB.ACP26.NCRE26', $pagare);
  }
}
