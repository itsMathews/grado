<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class Asignar extends Model
{
    protected $table='adicional';
    protected $primaryKey="id";
    public $timestamps=false;

protected $fillable =[
    'fecha',
    'descripcion',
    'valor',
    'estado'

];


protected $guarded =[

];
}
