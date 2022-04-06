<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class Adicional extends Model
{
    protected $table='adicional';
    protected $primaryKey="id";
    public $timestamps=false;

protected $fillable =[
    'fecha',
    'descripcion',
    'estado'

];


protected $guarded =[

];
}
