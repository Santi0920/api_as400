<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ACP05 extends Model {

  use HasFactory;

  //Esta tabla contiene la mayor parte de información de los asociados
  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP05';


  public function scopeAsociado($query, $cuenta){
    return $query->selectRaw('RTRIM(NCTA05) AS CUENTA,
                RTRIM(DESC05) AS NOMBRES,
                RTRIM(NNIT05) AS CEDULA,
                RTRIM(NOMI05) AS CODNOMINA,
                RTRIM(DESC04) AS NONNOMINA,
                RTRIM(DEPE05) AS CODDEPENDENCIA,
                RTRIM(DESC02) AS NOMDEPEDENCIA,
                RTRIM(ENTI05) AS ENTIDAD')
                 ->join('COLIB.ACP04', 'COLIB.ACP05.NOMI05', '=', 'COLIB.ACP04.NOMI04')
                 ->join('COLIB.ACP02', 'COLIB.ACP05.ENTI05', '=', 'COLIB.ACP02.ENTI02')
                 ->where('COLIB.ACP05.NCTA05', $cuenta)
                 ->whereRaw('COLIB.ACP02.DEPE02 = COLIB.ACP05.DEPE05');
  }


  public function scopeCuentas($query, $cedula){
    return $query->selectRaw('(FEVI05 + 19000000) AS FECHA_VIN,
                              (CASE
                                WHEN FRDA05 = 0 THEN FRDA05 ELSE (FRDA05 + 19000000)
                              END) AS FECHA_RET,
                              INDC05 AS ESTADO')
                 ->where('NNIT05', $cedula)
                 ->where('INDC05', 0)
                 ->orderBy('FEVI05', 'ASC');
  }

  public function scopeValidarAsociado($query, $cedula){
    return $query->selectRaw('RTRIM(NNIT05) AS CEDULA')->where('NNIT05', $cedula);
  }



  public function scopePagare($query, $agencia){

    $currentYear = now()->year % 100; // Obtiene los últimos dos dígitos del año
    $currentMonth = now()->format('m');
    $currentDay = now()->format('d');

    $feci26Value = sprintf('%02d%02d%02d', $currentYear, $currentMonth, $currentDay);
    $formateado = '1'.$feci26Value;
    $result = $query->selectRaw('RTRIM(COLIB.ACP05.DIST05) AS AGENCIA,
    RTRIM(COLIB.ACP05.NCTA05) AS CUENTA,
    RTRIM(COLIB.ACP05.NNIT05) AS CEDULA,
    RTRIM(COLIB.ACP05.DESC05) AS NOMBRES,
    RTRIM(COLIB.ACP26.NCRE26) AS IDPAGARE,
    RTRIM(COLIB.ACP23.TCRE23) AS LINEA,
    RTRIM(COLIB.ACP23.CAPI23) AS CAPITAL,
    RTRIM(COLIB.ACP23.NCUO23) AS NCUOTAS,
    RTRIM(COLIB.ACP23.VCUO23) AS VCUOTAS,
    RTRIM(COLIB.ACP23.TASA23) AS TASA,
    RTRIM(COLIB.ACP23.STAT23) AS ESTADO,
    RTRIM(COLIB.ACP05.NOMI05) AS NOMINA,
    RTRIM(COLIB.ACP05.ENTI05) AS ENTIDAD,
    RTRIM(COLIB.ACP05.DEPE05) AS DEPENDENCIA,
    RTRIM(COLIB.ACP05.DIR305) AS DIRECCION,
    RTRIM(COLIB.ACP05.TEL305) AS FIJO,
    RTRIM(COLIB.ACP26.FEC126) AS PCUOTA,
    RTRIM(COLIB.ACP26.FECU26) AS UCUOTA,
    RTRIM(COLIB.ACP26.USER26) AS USUARIO,
    RTRIM(COLIB.ACP26.MOGA26) AS GARANTIA,
    RTRIM(COLIB.ACP26.INTP26) AS INTERES,
    RTRIM(COLIB.ACP054.MAIL05) AS CORREO,
    RTRIM(COLIB.ACP054.TCEL05) AS CELULAR,
    RTRIM(COLIB.ACP04.DESC04) AS NOMNOMINA,
    RTRIM(COLIB.ACP06.DESC06) AS LINEANOM
    ')
    ->join('COLIB.ACP23', 'COLIB.ACP23.NCTA23', '=', 'COLIB.ACP05.NCTA05')
    ->join('COLIB.ACP26', 'COLIB.ACP23.NCTA23', '=', 'COLIB.ACP26.NCTA26')
    ->join('COLIB.ACP06', 'COLIB.ACP06.TCRE06', '=', 'COLIB.ACP23.TCRE23')
    ->join('COLIB.ACP054', 'COLIB.ACP054.NCTA05', '=', 'COLIB.ACP23.NCTA23')
    ->join('COLIB.ACP04', 'COLIB.ACP04.NOMI04', '=', 'COLIB.ACP05.NOMI05')
    ->where('COLIB.ACP05.DIST05', '=', $agencia)
    ->where('COLIB.ACP23.STAT23', '=', '1')
    ->where('COLIB.ACP26.FECI26', '>=', '1240614'); // Contigencia as-400

    return $result;


}

public function scopeAsegurabilidad($query, $cuenta){
  return $query->selectRaw('RTRIM(COLIB.ACP05.APE205) AS APELLIDO2,
              RTRIM(COLIB.ACP05.APE105) AS APELLIDO1,
              RTRIM(COLIB.ACP05.NOMB05) AS NOMBRES,
              RTRIM(COLIB.ACP05.NNIT05) AS CEDULA,
              RTRIM(COLIB.ACP05.BASE05) AS SALARIO,
              RTRIM(COLIB.ACP05.TIDE05) AS TIPODOC,
              RTRIM(COLIB.ACP05.DIRE05) AS DIRECCION,
              RTRIM(COLIB.ACP05.CIUD05) AS CIUDAD,
              RTRIM(COLIB.ACP05.FECN05) AS FECHAN,
              RTRIM(COLIB.ACP05.SEXO05) AS SEXO,
              RTRIM(COLIB.ACP05.CARG05) AS CARGO,
              RTRIM(COLIB.ACP05.ESTC05) AS ECIVIL,
              RTRIM(COLIB.ACP054.MAIL05) AS CORREO,
              RTRIM(COLIB.ACP054.TCEL05) AS CELULAR,
              RTRIM(COLIB.ACP054.TCE205) AS CELULAR2,
              RTRIM(COLIB.ACP054.FEXP05) AS FECHAE,
              RTRIM(COLIB.ACP054.DEPO05) AS DEPORTE,
              RTRIM(COLIB.ACP05.LNAC05) AS LUGAR,
              RTRIM(COLIB.ACP05.TELE05) AS TELEFONO')
              ->join('COLIB.ACP054', 'COLIB.ACP054.NCTA05', '=', 'COLIB.ACP05.NCTA05')
               ->where('COLIB.ACP05.NCTA05', $cuenta);
}




public function scopeFecha($query, $cuenta){
  return $query->selectRaw('RTRIM(DESC05) AS NOMBRES,
      RTRIM(NNIT05) AS CEDULA,
      RTRIM(COLIB.ACP05.NCTA05) AS CUENTA,
      RTRIM(COLIB.ACP05.FECN05) AS FECHA,
      RTRIM(CARG05) AS CARGO,
      RTRIM(PROF05) AS PROFESION')
      ->where('COLIB.ACP05.NCTA05', $cuenta);
}


// RTRIM(FEC126) AS 1CUOTA,
// RTRIM(FECU26) AS UCUOTA

public function scopeAsociadoNombre($query, $cedula){
    return $query->selectRaw('
                RTRIM(COLIB.ACP05.NCTA05) AS CUENTA,
                RTRIM(COLIB.ACP05.DESC05) AS NOMBRES,
                RTRIM(COLIB.ACP05.FRDA05) AS RETIRO,
                RTRIM(COLIB.ACP05.BASE05) AS SALARIO,
                RTRIM(COLIB.ACP05.NOMI05) AS NOMINA,
                RTRIM(COLIB.ACP04.DESC04) AS NOMNOMINA,
                RTRIM(COLIB.ACP054.MAIL05) AS CORREO,
                RTRIM(COLIB.ACP054.TCEL05) AS CELULAR,
                RTRIM(COLIB.ACP054.WHA105) AS WHATSAPP
            ')
            ->join('COLIB.ACP054', 'COLIB.ACP054.NCTA05', '=', 'COLIB.ACP05.NCTA05')
            ->join('COLIB.ACP04', 'COLIB.ACP05.NOMI05', '=', 'COLIB.ACP04.NOMI04')
            ->join('COLIB.ACP02', 'COLIB.ACP05.ENTI05', '=', 'COLIB.ACP02.ENTI02')
            ->where('COLIB.ACP05.NNIT05', $cedula)
            ->whereRaw('COLIB.ACP02.DEPE02 = COLIB.ACP05.DEPE05');
}

  public function scopeAsociadoRetiro($query, $cuenta){
    return $query->selectRaw('RTRIM(NCTA05) AS CUENTA,
                RTRIM(DESC05) AS NOMBRES,
                RTRIM(NNIT05) AS CEDULA,
                RTRIM(FERE05) AS RETIRO')
                 ->join('COLIB.ACP04', 'COLIB.ACP05.NOMI05', '=', 'COLIB.ACP04.NOMI04')
                 ->join('COLIB.ACP02', 'COLIB.ACP05.ENTI05', '=', 'COLIB.ACP02.ENTI02')
                 ->where('COLIB.ACP05.NCTA05', $cuenta)
                 ->whereRaw('COLIB.ACP02.DEPE02 = COLIB.ACP05.DEPE05');
  }

  public function scopeConsultarAsociado($query, $cedula){
    $result = $query->selectRaw('
    RTRIM(COLIB.ACP05.DIST05) AS AGENCIA,
    RTRIM(COLIB.ACP05.NCTA05) AS CUENTA,
    RTRIM(COLIB.ACP05.NNIT05) AS CEDULA,
    RTRIM(COLIB.ACP05.DESC05) AS NOMBRE,
    RTRIM(COLIB.ACP05.FRDA05) AS FRETIRO,
    RTRIM(COLIB.ACP93.AAUX93) AS AGENCIAAUXILIAR,
    RTRIM(COLIB.ACP93.ASAL93) AS SALDOAPORTES,
    RTRIM(COLIB.ACP93.CUPO93) AS CUPO,
    RTRIM(COLIB.ACP93.ACUO93) AS CUOTAAPORTES,
    RTRIM(COLIB.ACP93.DSAL93) AS SALDOREEINTEGROS,
    RTRIM(COLIB.ACP93.ESCR93) AS DEUDAESPECIAL,
    RTRIM(COLIB.ACP93.APVE93) AS VENCIDOAPORTES,
    RTRIM(COLIB.ACP93.ORCR93) AS DEUDAORDINARIA,
    RTRIM(COLIB.ACP93.ESVE93) AS VENCIDOESPECIAL,
    RTRIM(COLIB.ACP93.ORVE93) AS VENCIDOORDINARIO,
    RTRIM(COLIB.ACP93.DNOM93) AS NOMBRENOMINA,
    RTRIM(COLIB.ACP93.DDEP93) AS NOMBREDEPENDENCIA,
    RTRIM(COLIB.ACP96.FECA96) AS FECHAINICIAL,
    RTRIM(COLIB.ACP96.NCRE96) AS NUMEROCREDITO,
    RTRIM(COLIB.ACP96.TCRE96) AS TIPOCREDITO,
    RTRIM(COLIB.ACP96.SCAP96) AS SALDOCAPITAL,
    RTRIM(COLIB.ACP96.INTI96) AS VALORCUOTAMES,
    RTRIM(COLIB.ACP96.REFO96) AS REINTEGROFONDO,
    RTRIM(COLIB.ACP96.RESE96) AS REINTEGROSEGURO,
    RTRIM(COLIB.ACP96.SINT96) AS SALDOINTERES,
    (SCAP96 + SINT96 - REFO96 - RESE96) AS TPAGAR,
    RTRIM(NNIT05) AS CEDULA,
    RTRIM(FRDA05) AS RETIRO')
    ->leftJoin('COLIB.ACP054', function ($join) {
        $join->on('COLIB.ACP05.EMPR05', '=', 'COLIB.ACP054.EMPR05')
             ->on('COLIB.ACP05.NCTA05', '=', 'COLIB.ACP054.NCTA05');
    })
    ->leftJoin('COLIB.ACP93', function ($join) {
        $join->on('COLIB.ACP05.NCTA05', '=', 'COLIB.ACP93.NCTA93')
             ->on('COLIB.ACP05.NNIT05', '=', 'COLIB.ACP93.NNIT93');
    })
    ->leftJoin('COLIB.ACP96', 'COLIB.ACP93.NCTA93', '=', 'COLIB.ACP96.NCTA96')
    ->leftJoin('COLIB.ACP03', 'COLIB.ACP05.DIST05', '=', 'COLIB.ACP03.DIST03')
    ->where('COLIB.ACP05.NCTA05', '<', '900000')
    ->where(function ($query) {
        $query->where('COLIB.ACP96.SCAP96', '>', 0)
              ->orWhereNull('COLIB.ACP96.SCAP96');
    })
    ->where('COLIB.ACP05.NNIT05', '=', $cedula)
    ->orderBy('AGENCIA')
    ->orderBy('NOMBRE')
    ->distinct();
    return $result;

    }
}
