<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ACP054 extends Model {

  use HasFactory;

  //Esta tabla complementa la información de los asociados de la tabla ACP05 
  protected $connection = 'odbc';
  protected $table      = 'COLIB.ACP054';
}
