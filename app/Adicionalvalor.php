<?php

namespace grado;

use Illuminate\Database\Eloquent\Model;

class Adicionalvalor extends Model
{

    protected $table='adicionalvalor';
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable =[
    'adicional',
    'fecha',
    'valor'
    

];


protected $guarded =[

];
}
