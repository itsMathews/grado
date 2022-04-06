<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table='menu';
    protected $primaryKey="id";
    public $timestamps=false;

protected $fillable =[
    'vmer1',
    'vmer2',
    'valm',
    'descripcion'
];


protected $guarded =[

];
}
