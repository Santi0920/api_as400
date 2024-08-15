<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ACP25 extends Model {
  
  use HasFactory;

  //Esta tabla contiene la mayor parte de información de los asociados 
  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP25';

  public function scopePagare($query, $pagare, $cuenta){
    return $query->selectRaw('RTRIM(NCTA25) AS CUENTA,
                RTRIM(NCRE25) AS PAGARE')
                 ->where('COLIB.ACP25.NCTA25', $cuenta)
                 ->where('COLIB.ACP25.NCRE25', $pagare);
  }
}
