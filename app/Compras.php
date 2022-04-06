<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    protected $table='compras';
    protected $primaryKey="id";
    public $timestamps=false;

protected $fillable =[
    'descripcion',
    'valor',
    'fecha',
    'estado'
];


protected $guarded =[

];


}
