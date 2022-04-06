<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    
  protected $table='ingreso';
    protected $primaryKey="id";
    public $timestamps=false;

protected $fillable =[
    'fecha',
    'descripcion',
    'valor',
    'alumno',
    'estado'

];


protected $guarded =[

];




}
