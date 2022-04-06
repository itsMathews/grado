<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
   
    protected $table='egreso';
    protected $primaryKey="id";
    public $timestamps=false;

protected $fillable =[
    'fecha',
    'descripcion',
    'valor',
    'profesor',
    'estado'

];


protected $guarded =[

];




}
