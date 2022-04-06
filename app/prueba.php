<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class prueba extends Model
{
    protected $table='prueba';

    protected $primaryKey='id';

    public $timestamps=true;

    protected $fillable=[

      'dat1',
      'dat2',
      'dat3'

     ];

}
