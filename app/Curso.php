<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table='curso';
    protected $primaryKey="id";
    public $timestamps=false;

protected $fillable =[
    'descripcion'
];


protected $guarded =[

];



}
