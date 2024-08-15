<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\as400Controller;
use App\Http\Controllers\AuthController;

//LOGIN PARA AUTENTICACION DE LA API
// Route::post('/login', [AuthController::class, 'login']);



// //SE CREA EN POSTMAN, SE DEBE ENVIAR name: , email:, password: y password_confirmation:
// Route::post('/register', [AuthController::class, 'register']);

    //EN USO PARA SOFTWARE DE DATACREDITO
    Route::get('/nomina/{nomina}', [as400Controller::class, 'nominadepen']);
    Route::get('/pagareunico/{pagare}/{cuenta}', [as400Controller::class, 'pagareunico']);
    Route::get('/garantia/{pagare}/{cuenta}', [as400Controller::class, 'garantia']);
    Route::get('/deseembolso/{pagare}/{cuenta}',[as400Controller::class, 'deseembolso']);
    Route::get('/asociado/{cuenta}', [as400Controller::class, 'asociado']);
    Route::get('/asegurabilidad/{cuenta}', [as400Controller::class, 'asegurabilidad']);
    Route::get('/estado/{cuenta}/{linea}/{capital}',[as400Controller::class, 'estado']);
    Route::get('/infopagare/{agencia}',[as400Controller::class, 'infopagare']);
    Route::get('/fechan/{cuenta}', [as400Controller::class, 'fechan']);
    Route::get('/deudatotal/{cuenta}', [as400Controller::class, 'deudatotal']);
    Route::get('/deudaespecial/{cuenta}', [as400Controller::class, 'creditoespecial']);
    Route::get('/nombre/{cedula}', [as400Controller::class, 'asociadonombre']);
    Route::get('/retiro/{cuenta}', [as400Controller::class, 'asociadoretiro']);
    Route::get('/consultarasociado/{cedula}', [as400Controller::class, 'consultarasociado']);



    // Route::get('/validar/asociado/{cedula}', [as400Controller::class, 'asociado_validar']);


    //DE PRUEBA PARA USO EN SOFTWARE SERVICIOS WEB

    /* Route::get('/datoscuenta/{cuenta}', [as400Controller::class, 'datoscuenta']); */


    // Route::middleware('auth:api')->group(function () {


    //     Route::get('/IntVencidos/{corte}/{cuenta}', [as400Controller::class, 'IntVencidos']);

    // //USO PARA SOFTWARE SERVICIOS WEB
    // Route::get('/credenciales/{cedula}', [as400Controller::class, 'credenciales']);




    // //NO SE ENCUENTRA EN USO DE NINGÚN SOFTWARE
    // Route::get('/nominas', [as400Controller::class, 'nominas']);
    // Route::get('/dependencia/{id_nomina}', [as400Controller::class, 'dependencia']);
    // Route::get('/agencia', [as400Controller::class, 'agencia']);
    // Route::get('/agencia/{cu}', [as400Controller::class, 'agencia_cu']);

// });








