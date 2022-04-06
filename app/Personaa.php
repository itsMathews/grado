<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class Personaa extends Model
{
    protected $table='persona';
    protected $primaryKey="id";
    public $timestamps=false;

protected $fillable =[
    'iden',
    'nombres',
    'apellidos',
    'direccion',
    'tel',
    'tipo',
    'estado'


];


protected $guarded =[

];
}
