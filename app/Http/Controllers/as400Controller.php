<?php

namespace App\Http\Controllers;

use DB;
use Response;
use DateTime;

use App\Models\ACP02;
use App\Models\ACP03;
use App\Models\ACP04;
use App\Models\ACP05;
use App\Models\ACP054;
use App\Models\ACP23;
use App\Models\ACP26;
use App\Models\ACP25;
use App\Models\ACP13;
use App\Models\ACP14;
use App\Models\ACP05PW;
use DateInterval;


use Illuminate\Http\Request;

date_default_timezone_set('America/Bogota');


class as400Controller extends Controller {

  public function fechan($cuenta){

    $asociado_cod = ACP05::fecha($cuenta)->get();

    if(sizeof($asociado_cod) != 0){
        $fechaNacimiento = $asociado_cod[0]->FECHA;

        // Obtener la fecha actual
        $fechaActual = date('Y-m-d');

        // Convertir la fecha de nacimiento al formato YYYY-MM-DD
        $fechaNacimientoFormateada = date('Y-m-d', strtotime($fechaNacimiento));

        // Calcular la diferencia en años
        $edad = date_diff(date_create($fechaNacimientoFormateada), date_create($fechaActual))->y;



        if($edad >= 70){
            $asociado = mb_convert_encoding([
                substr($asociado_cod[0]->NOMBRES, 0),
                $asociado_cod[0]->CEDULA,
                $asociado_cod[0]->CUENTA,
                $asociado_cod[0]->FECHA,
                $asociado_cod[0]->FECHA_EXP,
                substr($asociado_cod[0]->CARGO, 0),
                substr($asociado_cod[0]->PROFESION, 0),
            ], "UTF-8", "iso-8859-1");

            return Response::json(['status' => 200, 'asociado' => $asociado]);
        } else {
            return Response::json(['status' => 422, 'message' => 'La persona no cumple con los 70 años de edad']);
        }
    }
}

  public function nominas(){

    $nomina_cod = ACP04::nominas()->get();

    foreach($nomina_cod as $nomina){
      $nominaArray[] = array(
        'ID'          => utf8_encode($nomina->NOMI04),
        'DESCRIPCION' => utf8_encode($nomina->DESCRIPCION)
      );
    }

    return Response::json(['status' => 200, 'nominas' => $nominaArray]);
  }

  public function dependencia($id_nomina){

    $dependecia_cod = ACP02::dependencias($id_nomina)->get();

    foreach($dependecia_cod as $dependencia){
      $dependenciaArray[] = array(
        'COD ENTIDAD'          => utf8_encode($dependencia->ID),
        'DESCRIPCION' => utf8_encode($dependencia->DESCRIPCION),
        'DEPENDENCIA' => utf8_encode($dependencia->CODDEPENDENCIA)
      );
    }

    return Response::json(['status' => 200, 'dependencias' => $dependenciaArray]);
  }

  public function agencia(){

    $agencia_cod = ACP03::agencias()->get();

    foreach ($agencia_cod as $agencia) {
      $agenciaArray[] = array(
        'ID'          =>utf8_encode($agencia->ID),
        'DESCRIPCION' =>utf8_decode($agencia->DESCRIPCION)
      );
    }

    return Response::json(['status' => 200, 'agencias' => $agenciaArray]);
  }

  public function agencia_cu($cu){

    $agencia_cod = ACP03::agencia($cu)->get();

    foreach ($agencia_cod as $agencia) {
      $agenciaArray[] = array(
        'ID'          =>utf8_encode($agencia->ID),
        'DESCRIPCION' =>utf8_decode($agencia->DESCRIPCION)
      );
    }

    return Response::json(['status' => 200, 'agencias' => $agenciaArray]);
  }

  //Trae información de un asociado por numero de cedula
  public function asociado($cuenta){

    $asociado_cod = ACP05::asociado($cuenta)->get();
    if(sizeof($asociado_cod) != 0){
      $asociado = mb_convert_encoding([
        'NOMBRES' => $asociado_cod[0]->NOMBRES,
        'CUENTA' => $asociado_cod[0]->CUENTA,
        'CEDULA' => $asociado_cod[0]->CEDULA,
        'CODIGONOMINA' => $asociado_cod[0]->CODNOMINA,
        'NOMBRENOMINA' => $asociado_cod[0]->NONNOMINA,
        '#DEPENDENCIA' => $asociado_cod[0]->CODDEPENDENCIA,
        'DEPENDENCIA' => $asociado_cod[0]->NOMDEPEDENCIA,
        'ENTIDAD' => $asociado_cod[0]->ENTIDAD,
    ], "UTF-8", "iso-8859-1");

      if(sizeof($asociado) != 0){
        return Response::json(['status'   => 200, 'asociado' => $asociado]);
      }else{
        return Response::json(['status'  => 422,
                             'message' => 'Este número de cuenta no esta activo']);
      }
    }else{
      return Response::json(['status'  => 422,
                             'message' => 'Este número de cuenta no se encuentra registrado']);
    }
  }

  public function asegurabilidad($cuenta){

    $asociado_cod = ACP05::asegurabilidad($cuenta)->get();
    if(sizeof($asociado_cod) != 0){
      $asociado = mb_convert_encoding([
        'APELLIDO1' => $asociado_cod[0]->APELLIDO1,
        'APELLIDO2' => $asociado_cod[0]->APELLIDO2,
        'NOMBRES' => $asociado_cod[0]->NOMBRES,
        'CEDULA' => $asociado_cod[0]->CEDULA,
        'SALARIO' => $asociado_cod[0]->SALARIO,
        'TIPODOC' => $asociado_cod[0]->TIPODOC,
        'DIRECCION' => $asociado_cod[0]->DIRECCION,
        'CIUDAD' => $asociado_cod[0]->CIUDAD,
        'FECHAN' => $asociado_cod[0]->FECHAN,
        'SEXO' => $asociado_cod[0]->SEXO,
        'CARGO' => $asociado_cod[0]->CARGO,
        'ECIVIL' => $asociado_cod[0]->ECIVIL,
        'CORREO' => $asociado_cod[0]->CORREO,
        'CELULAR' => $asociado_cod[0]->CELULAR,
        'CELULAR2' => $asociado_cod[0]->CELULAR2,
        'TELEFONO' => $asociado_cod[0]->TELEFONO,
        'LUGAR' => $asociado_cod[0]->LUGAR,
        'FECHAE' => $asociado_cod[0]->FECHAE,
        'DEPORTE' => $asociado_cod[0]->DEPORTE,
    ], "UTF-8", "iso-8859-1");

      if(sizeof($asociado) != 0){
        return Response::json(['status'   => 200, 'asociado' => $asociado]);
      }else{
        return Response::json(['status'  => 422,
                             'message' => 'Este número de cuenta no esta activo']);
      }
    }else{
      return Response::json(['status'  => 422,
                             'message' => 'Este número de cuenta no se encuentra registrado']);
    }
  }


  public function nominadepen($nomina){

    $nomina_cod = ACP02::nomina($nomina)->get();


    if(sizeof($nomina_cod) != 0){

      foreach($nomina_cod as $dpnomina){
        $dpnominaArray[] = array(

          'CODIGONOMINA' => $dpnomina->CODNOMINA,
          'NOMBRENOMINA' => $dpnomina->NONNOMINA,
          'CODDEPENDENCIA' => $dpnomina->CODDEPENDENCIA,
          'NOMDEPEDENCIA' => $dpnomina->NOMDEPEDENCIA,
          'ENTIDAD' => $dpnomina->ENTIDAD,

        );
      }


        return Response::json(['status'   => 200, 'nomina' => $dpnominaArray]);

    }else{
      return Response::json(['status'  => 422,
                            'message' => 'Esta nomina no se encuentra registrado']);
    }
  }


  public function asociado_validar($cedula){
    $asociado = ACP05::ValidarAsociado($cedula)->get();

    if(sizeof($asociado) != 0){
      return Response::json(['status' => 200,
                            'Asociado' => $asociado,
                            'message' => 'Cédula se encuentra en la S400!']);
    }else {
      return Response::json(['status' => 422,
                            'message' => 'Esta cédula no existe en la S400!']);
    }

  }


  public function garantia($pagare, $cuenta){
    $garantia_info = ACP26::garantia($pagare, $cuenta)->get();

      if(sizeof($garantia_info) != 0){
        $garantia = mb_convert_encoding([
          'CUENTA' => $garantia_info[0]->CUENTA,
          'PAGARE' => $garantia_info[0]->PAGARE,
          'GARANTIA' => $garantia_info[0]->GARANTIA
      ], "UTF-8", "iso-8859-1");

        if(sizeof($garantia) != 0){
          return Response::json(['status'   => 200, 'garantia' => $garantia]);
        }else{
          return Response::json(['status'  => 422,
                               'message' => 'Este número de pagaré no esta activo']);
        }
      }else{
        return Response::json(['status'  => 422,
                               'message' => 'Este número de pagaré no se encuentra registrado!']);
      }
    }

    public function pagareunico($pagare, $cuenta){
      $pagareunico_info = ACP25::pagare($pagare, $cuenta)->get();

        if(sizeof($pagareunico_info) != 0){
          $pagareunico = mb_convert_encoding([
            'CUENTA' => $pagareunico_info[0]->CUENTA,
            'PAGARE' => $pagareunico_info[0]->PAGARE
        ], "UTF-8", "iso-8859-1");

          if(sizeof($pagareunico) != 0){
            return Response::json(['status'   => 200, 'PagareUnico' => $pagareunico]);
          }else{
            return Response::json(['status'  => 422,
                                 'message' => 'Este número de pagaré no esta activo']);
          }
        }else{
          return Response::json(['status'  => 422,
                                 'message' => 'Este número de pagaré no se encuentra registrado!']);
        }
      }





    public function deseembolso($pagare, $cuenta){
      $deseembolso_info = ACP13::deseembolso($pagare, $cuenta)->get();

        if(sizeof($deseembolso_info) != 0){
          $deseembolso = mb_convert_encoding([
            'CUENTA' => $deseembolso_info[0]->CUENTA,
            'PAGARE' => $deseembolso_info[0]->PAGARE,
            'FECHADESEEMBOLSO' => $deseembolso_info[0]->FECHADESEEMBOLSO
        ], "UTF-8", "iso-8859-1");

          if(sizeof($deseembolso) != 0){
            return Response::json(['status'   => 200, 'deseembolso' => $deseembolso]);
          }else{
            return Response::json(['status'  => 422,
                                 'message' => 'Este número de pagaré no esta activo']);
          }
        }else{
          return Response::json(['status'  => 422,
                                 'message' => 'Este número de pagaré no se encuentra registrado en el ACP13!']);
        }
      }

      public function credenciales($cedula){
        $login_info = ACP05PW::credenciales($cedula)->get();

          if(sizeof($login_info) != 0){
            $login = mb_convert_encoding([
              'CEDULA' => $login_info[0]->CEDULA,
              'CUENTA' => $login_info[0]->CUENTA,
              'PASSWORD' => $login_info[0]->PASS,
              'CORREO' => $login_info[0]->CORREO,
              'TIPO' => $login_info[0]->TIPO,
              'ESTADO' => $login_info[0]->ESTADO,
              'DESCRIPCION' => $login_info[0]->DESCRIPCION,
              'FECHA' => $login_info[0]->FECHA,
              'IP' => $login_info[0]->IP,
              'ID' => $login_info[0]->ID,

          ], "UTF-8", "iso-8859-1");

            if(sizeof($login) != 0){
              return Response::json(['status'   => 200, 'login' => $login]);
            }else{
              return Response::json(['status'  => 422,
                                   'message' => 'Este usuario no esta activo']);
            }
          }else{
            return Response::json(['status'  => 422,
                                   'message' => 'Este usuario no se encuentra registrado!']);
          }
        }


        public function estado($cuenta, $linea,$capital){
          $estado_info = ACP23::estado($cuenta,$linea,$capital)->get();

            if(sizeof($estado_info) != 0){
              $estado = mb_convert_encoding([
                'EMPRESA' => $estado_info[0]->EMPRESA,
                'CAPITAL' => $estado_info[0]->CAPITAL,
                'ESTADO' => $estado_info[0]->ESTADO,
            ], "UTF-8", "iso-8859-1");

              if(sizeof($estado) != 0){
                return Response::json(['status'   => 200, 'estado' => $estado]);
              }else{
                return Response::json(['status'  => 422,
                                     'message' => 'Este número de pagaré no esta activo']);
              }
            }else{
              return Response::json(['status'  => 422,
                                     'message' => 'NO se puede registrar en el software de pagaré puesto a que ha sido deseembolsado o anulado!']);
            }
          }

          public function infopagare($agencia){
            $pagare_cod = ACP05::pagare($agencia)->get();
            $id = 1;

            foreach($pagare_cod as $pagare){
              //dd(utf8_encode($pagare->ORDINARIO));

              $pagareArray[] = array(
                'ID' => ($id++),
                'AGENCIA'          => utf8_encode($pagare->AGENCIA),
                'CUENTA'          => utf8_encode($pagare->CUENTA),
                'CEDULA'          => utf8_encode($pagare->CEDULA),
                'NOMBRES'          => utf8_encode($pagare->NOMBRES),
                'IDPAGARE' => utf8_encode($pagare->IDPAGARE),
                'LINEA' => utf8_encode($pagare->LINEA),
                'CAPITAL' => utf8_encode($pagare->CAPITAL),
                'NCUOTAS' => utf8_encode($pagare->NCUOTAS),
                'VCUOTAS' => utf8_encode($pagare->VCUOTAS),
                'TASA' => utf8_encode($pagare->TASA),
                'ESTADO' => utf8_encode($pagare->ESTADO),
                'NOMINA' => utf8_encode($pagare->NOMINA),
                'ENTIDAD' => utf8_encode($pagare->ENTIDAD),
                'DEPENDENCIA' => utf8_encode($pagare->DEPENDENCIA),
                'DIRECCION' => utf8_encode($pagare->DIRECCION),
                'FIJO' => utf8_encode($pagare->FIJO),
                'PCUOTA' => utf8_encode($pagare->PCUOTA),
                'UCUOTA' => utf8_encode($pagare->UCUOTA),
                'USUARIO' => utf8_encode($pagare->USUARIO),
                'GARANTIA' => utf8_encode($pagare->GARANTIA),
                'INTERES' => utf8_encode($pagare->INTERES),
                'CORREO' => utf8_encode($pagare->CORREO),
                'CELULAR' => utf8_encode($pagare->CELULAR),
                'NOMNOMINA' => utf8_encode($pagare->NOMNOMINA),
                'LINEANOM' => utf8_encode($pagare->LINEANOM),
              );
            }

            return Response::json(['status' => 200, 'pagares' => $pagareArray]);
          }

          public function creditoespecial($cuenta){
            $creditoespecial_info = ACP13::creditoespecial($cuenta)->get();

            if (sizeof($creditoespecial_info) != 0) {
              $creditoespecial = mb_convert_encoding([
                'ESPECIAL' => $creditoespecial_info[0]->ESPECIAL

            ], "UTF-8", "iso-8859-1");
                if (sizeof($creditoespecial) != 0) {
                    return response()->json(['status' => 200, 'creditoespecial' => $creditoespecial]);
                } else {
                    return response()->json(['status' => 422, 'message' => 'Este usuario no esta activo']);
                }
            } else {
                return response()->json(['status' => 422, 'message' => 'Este usuario no se encuentra registrado!']);
            }
          }

          public function deudatotal($cuenta){
            $creditoordinario_info = ACP13::creditoordinario($cuenta)->get();
            $creditoespecial_info = ACP13::creditoespecial($cuenta)->get();

            if (sizeof($creditoordinario_info) != 0 && sizeof($creditoespecial_info) != 0) {
                $creditoordinario = mb_convert_encoding([
                    'ORDINARIO' => $creditoordinario_info[0]->ORDINARIO
                ], "UTF-8", "iso-8859-1");

                $creditoespecial = mb_convert_encoding([
                    'ESPECIAL' => $creditoespecial_info[0]->ESPECIAL
                ], "UTF-8", "iso-8859-1");

                $deudatotal = $creditoordinario['ORDINARIO'] + $creditoespecial['ESPECIAL'];

                if ($deudatotal != 0) {
                    return response()->json(['status' => 200, 'deudatotal' => $deudatotal]);
                } else {
                    return response()->json(['status' => 422, 'deudatotal' => 0, 'message' => 'Este usuario no tiene crédito activo']);
                }
            } else {
                return response()->json(['status' => 422, 'message' => 'Este usuario no se encuentra registrado!']);
            }
        }




          public function IntVencidos($corte, $cuenta){
            $IntVencidos_info = ACP14::IntVencidos($corte, $cuenta)->get();

              if(sizeof($IntVencidos_info) != 0){
                $IntVencidos = mb_convert_encoding([
                  'INTVENCIDOS' => $IntVencidos_info[0]->INTVENCIDOS

              ], "UTF-8", "iso-8859-1");

                if(sizeof($IntVencidos) != 0){
                  return Response::json(['status'   => 200, 'IntVencidos' => $IntVencidos]);
                }else{
                  return Response::json(['status'  => 422,
                                       'message' => 'Este número de pagaré no esta activo']);
                }
              }else{
                return Response::json(['status'  => 422,
                                       'message' => 'Este número de pagaré no se encuentra registrado en el ACP13!']);
              }
            }


              //Trae información de un asociado por numero de cedula
              public function asociadonombre($cedula)
              {
                  $asociado_cod = ACP05::asociadoNombre($cedula)->get();

                  if ($asociado_cod->isNotEmpty()) {
                    $ultima_cuenta = $asociado_cod->pluck('CUENTA')->last();
                    $ultimo_salario = $asociado_cod->pluck('SALARIO')->last();
                    $ultimo_nomina = $asociado_cod->pluck('NOMINA')->last();
                    $ultimo_nomnomina = $asociado_cod->pluck('NOMNOMINA')->last();
                      $asociado = mb_convert_encoding([
                          'NOMBRES' => $asociado_cod[0]->NOMBRES,
                          'CUENTA' => $ultima_cuenta,
                          'RETIRO' => $asociado_cod[0]->RETIRO,
                          'SALARIO' => $ultimo_salario,
                          'NOMINA' => $ultimo_nomina,
                          'NOMNOMINA' => $ultimo_nomnomina,
                          'CELULAR' => $asociado_cod[0]->CELULAR,
                          'CORREO' => $asociado_cod[0]->CORREO,
                          'WHATSAPP' => $asociado_cod[0]->WHATSAPP,

                      ], "UTF-8", "iso-8859-1");

                      return response()->json(['status' => 200, 'asociado' => $asociado]);
                  } else {
                      return response()->json(['status' => 422, 'message' => 'Este número de cuenta no está registrado']);
                  }
              }

              public function asociadoretiro($cuenta)
              {
                  $asociado_cod = ACP05::asociadoRetiro($cuenta)->get();

                  if ($asociado_cod->isNotEmpty()) {
                      $asociado = mb_convert_encoding([
                          'NOMBRES' => $asociado_cod[0]->NOMBRES,
                          'CUENTA' => $asociado_cod[0]->CUENTA,
                          'RETIRO' => $asociado_cod[0]->RETIRO,
                          'CEDULA' => $asociado_cod[0]->CEDULA,
                      ], "UTF-8", "iso-8859-1");

                      return response()->json(['status' => 200, 'asociado' => $asociado]);
                  } else {
                      return response()->json(['status' => 422, 'message' => 'Este número de cuenta no está registrado']);
                  }
              }


              public function consultarasociado($cedula)
              {
                  try {
                      $asociados = ACP05::consultarAsociado($cedula)->get();
                      $asociadoArray = [];


                      foreach ($asociados as $index => $asociado) {
                          $asociadoArray[] = [
                              'ID' => $index + 1,
                              'AGENCIA' => utf8_encode($asociado->AGENCIA),
                              'CUENTA' => utf8_encode($asociado->CUENTA),
                              'CEDULA' => utf8_encode($asociado->CEDULA),
                              'NOMBRE' => utf8_encode($asociado->NOMBRE),
                              'FRETIRO' => utf8_encode($asociado->FRETIRO),
                              'AGENCIAAUXILIAR' => utf8_encode($asociado->AGENCIAAUXILIAR),
                              'SALDOAPORTES' => utf8_encode($asociado->SALDOAPORTES),
                              'CUPO' => utf8_encode($asociado->CUPO),
                              'CUOTAAPORTES' => utf8_encode($asociado->CUOTAAPORTES),
                              'SALDOREEINTEGROS' => utf8_encode($asociado->SALDOREEINTEGROS),
                              'DEUDAESPECIAL' => utf8_encode($asociado->DEUDAESPECIAL),
                              'VENCIDOAPORTES' => utf8_encode($asociado->VENCIDOAPORTES),
                              'DEUDAORDINARIA' => utf8_encode($asociado->DEUDAORDINARIA),
                              'VENCIDOESPECIAL' => utf8_encode($asociado->VENCIDOESPECIAL),
                              'VENCIDOORDINARIO' => utf8_encode($asociado->VENCIDOORDINARIO),
                              'NOMBRENOMINA' => utf8_encode($asociado->NOMBRENOMINA),
                              'NOMBREDEPENDENCIA' => utf8_encode($asociado->NOMBREDEPENDENCIA),
                              'FECHAINICIAL' => utf8_encode($asociado->FECHAINICIAL),
                              'NUMEROCREDITO' => utf8_encode($asociado->NUMEROCREDITO),
                              'TIPOCREDITO' => utf8_encode($asociado->TIPOCREDITO),
                              'SALDOCAPITAL' => utf8_encode($asociado->SALDOCAPITAL),
                              'VALORCUOTAMES' => utf8_encode($asociado->VALORCUOTAMES),
                              'REINTEGROFONDO' => utf8_encode($asociado->REINTEGROFONDO),
                              'REINTEGROSEGURO' => utf8_encode($asociado->REINTEGROSEGURO),
                              'SALDOINTERES' => utf8_encode($asociado->SALDOINTERES),
                              'TPAGAR' => utf8_encode($asociado->TPAGAR),
                          ];
                      }

                      return response()->json(['status' => 200, 'asociados' => $asociadoArray]);
                  } catch (\Exception $e) {
                      return response()->json(['status' => 500, 'message' => 'Error al consultar asociados: ' . $e->getMessage()], 500);
                  }
              }


}
