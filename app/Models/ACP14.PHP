<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ACP14 extends Model{
  
  use HasFactory;

  //Tabla que contiene toda la información de las dependencias. 
  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP14';

  //SOFTWARE DE SERVICIOS

  

    public function scopeIntVencidos($query, $cuenta, $corte){
        return $query->selectRaw('SUM(CINT14 + SIMO14 + SCJO14 + CICO14) AS INTVENCIDOS')
                    ->from('COLIB.ACP14')
                    ->where('NCTA14', '=', $cuenta)
                    ->where('CCAP14', '>' , 0)
                    ->where('VCTO14', '<=' , $corte);
    }
    


     
    

}
