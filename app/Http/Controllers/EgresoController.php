<?php

namespace grado\Http\Controllers;

use Illuminate\Http\Request;


use grado\Http\Requests;
use grado\Egreso;
use grado\Alumno;
use Illuminate\Support\Facades\Redirect;
use grado\Http\Requests\EgresoFormRequest;
use DB;
use PDF;

class EgresoController extends Controller
{


public function __construct(){}

	public function index( Request $Requests){

    if($Requests){

     $query=trim($Requests->get('search'));



     $egreso=DB::table('persona as p')
     ->join('Egreso as e','p.id','=','e.profesor')
     ->select('e.id as ideg','e.descripcion as edes','e.valor as eval','e.fecha as efe','e.estado as eest','nombres','apellidos')
     ->paginate(7);


     $profesor=DB::table('persona')->where('tipo','=','1')->where('estado','=','0')->orderBy('nombres','desc')->paginate(7);

     return view('preescolar.egreso.index',["egreso"=>$egreso,"search"=>$query,"profesor"=>$profesor]);

    }

	}

	public function create(){

    return view('preescolar.egreso.create');


	}

	public function store(EgresoFormRequest $request){

		$egreso = new egreso;
		$egreso->fecha=$request->get('fecha');
		$egreso->descripcion=$request->get('descripcion');
		$egreso->valor=$request->get('valor');
		$egreso->estado='0';
		$egreso->save();
		return Redirect::to('preescolar/egreso');

	}

	public function show($id){

    return view("preescolar.egreso.show",["egreso"=>Egreso::findorFail($id)]);
  }

	public function edit($id){

    return view("preescolar.egreso.edit",["egreso"=>Egreso::findorFail($id)]);

	}

	public function update(EgresoFormRequest $request,$id){

    $egreso=Egreso::findorFail($id);
    $egreso->descripcion=$request->get('descripcion');
    $egreso->fecha=$request->get('fecha');
    $egreso->valor=$request->get('valor');
    $egreso->update();
    return Redirect::to('preescolar/egreso');

	}

    public function destroy(){}


    /*

    select p.id,p.nombres,
(select a.adicional from adicionales a where p.id=a.alumno and a.adicional=2)
from persona p where p.tipo=2

    */



    public function nuevo(Request $Requests){

         $egreso = new Egreso;
         $egreso->descripcion = $Requests->descripcion;
         $egreso->fecha = $Requests->fecha;
         $egreso->profesor = $Requests->profesor;
         $egreso->valor = $Requests->valor;
         $egreso->estado = '0';
         $egreso->save();









         //return response()->json(['msj'=>$egreso]);

    }


    public function reporte(){


      $html = '<br><br><br><br><br><br>';

       $egreso=DB::table('persona as p')
     ->join('Egreso as e','p.id','=','e.profesor')
     ->select('e.id as ideg','e.descripcion as edes','e.valor as eval','e.fecha as efe','e.estado as eest','nombres','apellidos')->get();

        $datos=sizeof($egreso);

         PDF::SetTitle('Reporte_Egreso');
        PDF::AddPage();


       $pos=0;

        //PDF::Image("img/logoreporte.png",10,10,30,30);

        if($datos>0){

        $html=$html.'<br> <table border="1" >';

        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Descripcion</td> <td  style="text-align:center">Valor</td> <td  style="text-align:center">Fecha</td> <td  style="text-align:center">Profesor</td><td  style="text-align:center">Estado</td> </tr>';

        for($i=0;$i<$datos;$i++){



        if($egreso[$i]->eest==0) {$estado="Activo";}else{$estado="Inactivo";}


        $html=$html.'<tr> <td style="text-align:center">'.$egreso[$i]->ideg .'</td> <td  style="text-align:center">'. $egreso[$i]->edes.'</td> <td  style="text-align:center">'. $egreso[$i]->eval.'</td> <td  style="text-align:center">'. $egreso[$i]->efe.'</td> <td  style="text-align:center">'. $egreso[$i]->nombres." ".$egreso[$i]->apellidos.'</td><td  style="text-align:center">'.$estado.'</td> </tr>';


        if($pos==42){

         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');
          $html='';


        }if($pos==43){

        PDF::AddPage();

        $html = '<br><br><br><br><br><br>';

        $html=$html.'<br> <table border="1" >';

        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Nombres</td> <td  style="text-align:center">Apellidos</td> <td  style="text-align:center">Direccion</td> <td  style="text-align:center">Estado</td> </tr>';


         $html=$html.'<tr> <td style="text-align:center">'.$egreso[$i]->ideg .'</td> <td  style="text-align:center">'. $egreso[$i]->edes.'</td> <td  style="text-align:center">'. $egreso[$i]->eval.'</td> <td  style="text-align:center">'. $egreso[$i]->efe.'</td> <td  style="text-align:center">'. $egreso[$i]->nombres." ".$egreso[$i]->apellidos.'</td><td  style="text-align:center">'.$estado.'</td> </tr>';

        PDF::Image("img/logoreporte.png",10,10,30,30);



          }

          $pos++;

        }

        if(strlen($html)>0){

         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');

        }

        }


    PDF::Output('Reporte_Egreso.pdf');



    }



}
