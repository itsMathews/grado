<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class Adicionales extends Model
{
    protected $table='adicionales';
    protected $primaryKey="id";
    public $timestamps=false;

protected $fillable =[
    'profesor',
    'alumno',
    'adicional',
    'tipo'

];


protected $guarded =[

];
}
