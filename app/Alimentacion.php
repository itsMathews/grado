<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class Alimentacion extends Model
{
   protected $table='alimentacion';
    protected $primaryKey="id";
    public $timestamps=false;

protected $fillable =[
    'fecha',
    'alumno',
    'profesor',
    'menu',
    'merienda1',
    'merienda2',
    'almuerzo'

];


protected $guarded =[

];
}
