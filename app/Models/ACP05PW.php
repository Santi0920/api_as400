<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ACP05PW extends Model {
  
  use HasFactory;

  //Esta tabla contiene la mayor parte de información personal de los asociados 
  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP05PW';

  public function scopeCredenciales($query, $cedula ){
    return $query->selectRaw(
                'RTRIM(COLIB.ACP05.NNIT05) AS CEDULA,
                RTRIM(COLIB.ACP05.NCTA05) AS CUENTA,
                RTRIM(PASSPW) AS PASS,
                RTRIM(MAIL05) AS CORREO,
                RTRIM(TIPOPW) AS TIPO,
                RTRIM(ESTAPW) AS ESTADO,
                RTRIM(DESC05) AS DESCRIPCION,
                RTRIM(FECHAEPW) AS FECHA,
                RTRIM(IPPW) AS IP,
                RTRIM(ID) AS ID')
                ->join('COLIB.ACP05', 'COLIB.ACP05PW.NNIT05', '=', 'COLIB.ACP05.NNIT05')
                ->join('COLIB.SESIONES', 'COLIB.ACP05PW.NNIT05', '=', 'COLIB.SESIONES.NNITPW')
                ->where('COLIB.ACP05PW.NNIT05', $cedula)
                ->orderBy('FECHAEPW', 'desc')
                ->limit(1); 
  }
}


/* "SELECT  ACP05.NNIT05,PASSPW,MAIL05,TIPOPW,ESTAPW,DESC05,DATE(FECHAEPW) ULTFEING,
TIME(FECHAEPW) ULTHRING,IPPW,MAX(ID) ID
FROM COLIB.ACP05PW ACP05PW,COLIB.ACP05 ACP05 LEFT JOIN COLIB.SESIONES SESIONES ON ACP05.NNIT05 = SESIONES.NNITPW 
WHERE ACP05PW.NNIT05= '$username' AND ACP05PW.NNIT05= ACP05.NNIT05  AND ESTAPW = 1 
GROUP BY ACP05.NNIT05,PASSPW,MAIL05,TIPOPW,ESTAPW,DESC05,FECHAEPW,IPPW 
ORDER BY FECHAEPW DESC 
FETCH FIRST ROWS ONLY"; */