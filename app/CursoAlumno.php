<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class CursoAlumno extends Model
{
    protected $table='cursoalumno';
    protected $primaryKey="id";
    public $timestamps=false;

protected $fillable =[
    'curso',
    'alumno'
   


];


protected $guarded =[

];
}
