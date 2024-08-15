<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asociados extends Model
{
  use HasFactory;

  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP05';

  protected $fillable  = [
    'NNIT05',
    'FECN05',
    'FRDA05'
  ];

  /**Esta función relaciona la BD ACP05 y ACP054, para validar datos de logueo
   * Campos Validacion: Cedula, Fecha de Nacimiento, Fecha Expedición.
  
  public function scopeDatosLogueo($query, $cedula, $fecha_nac){
    if (($cedula) && ($fecha_nac) ) {
      return $query->where($tipo,'like',"%$buscar%");
    }
  }**/
}
