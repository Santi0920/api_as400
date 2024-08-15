<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ACP13 extends Model {
  
  use HasFactory;

  //Esta tabla contiene la mayor parte de información de los asociados 
  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP13';

  public function scopeDeseembolso($query, $pagare, $cuenta){
    return $query->selectRaw('RTRIM(NCTA13) AS CUENTA,
                RTRIM(NCRE13) AS PAGARE,
                RTRIM(FECI13) AS FECHADESEEMBOLSO')
                 ->where('COLIB.ACP13.NCTA13', $cuenta)
                 ->where('COLIB.ACP13.NCRE13', $pagare);
  }

  public function scopeCreditoEspecial($query, $cuenta){
    return $query->selectRaw('SUM(SCAP13) AS ESPECIAL')
                ->from('COLIB.ACP13')
                ->where('SCAP13', '>', 0)
                ->where('NCTA13', $cuenta)
                ->whereExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                              ->from('COLIB.ACP06')
                              ->whereColumn('COLIB.ACP13.TCRE13', 'COLIB.ACP06.TCRE06')
                              ->where('CLAS06', 'E');
                });
  }


  public function scopeCreditoOrdinario($query, $cuenta){
    return $query->selectRaw('SUM(SCAP13) AS ORDINARIO')
                ->from('COLIB.ACP13')
                ->where('SCAP13', '>', 0)
                ->where('NCTA13', $cuenta)
                ->whereExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                              ->from('COLIB.ACP06')
                              ->whereColumn('COLIB.ACP13.TCRE13', 'COLIB.ACP06.TCRE06')
                              ->where('CLAS06', 'O');
                });
  }
}
