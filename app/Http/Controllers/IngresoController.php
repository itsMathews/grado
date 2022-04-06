<?php

namespace grado\Http\Controllers;

use Illuminate\Http\Request;

use grado\Http\Requests;
use grado\Ingreso;
use grado\Alumno;
use Illuminate\Support\Facades\Redirect;
use grado\Http\Requests\IngresoFormRequest;
use DB;
use PDF;

class IngresoController extends Controller
{
    

public function __construct(){}

	public function index( Request $Requests){

    if($Requests){

     $query=trim($Requests->get('search'));
     


     $ingreso=DB::table('persona as p')
     ->join('ingreso as i','p.id','=','i.alumno')
     ->select('i.id as idin','i.descripcion as ides','i.valor as ival','i.fecha as ife','i.estado as iest','nombres','apellidos')
     ->paginate(7);  


     $alumno=DB::table('persona')->where('tipo','=','2')->where('estado','=','0')->orderBy('nombres','desc')->paginate(7);     
    
     return view('preescolar.ingreso.index',["ingreso"=>$ingreso,"search"=>$query,"alumno"=>$alumno]);

    }

	}

	public function create(){

    return view('preescolar.ingreso.create');


	}

	public function store(IngresoFormRequest $request){

		$ingreso = new Ingreso;
		$ingreso->fecha=$request->get('fecha');
		$ingreso->descripcion=$request->get('descripcion');
		$ingreso->valor=$request->get('valor');
		$ingreso->estado='0';
		$ingreso->save();
		return Redirect::to('preescolar/ingreso');

	}

	public function show($id){

    return view("preescolar.ingreso.show",["ingreso"=>Ingreso::findorFail($id)]);
  }

	public function edit($id){

    return view("preescolar.ingreso.edit",["ingreso"=>Ingreso::findorFail($id)]);

	}

	public function update(IngresoFormRequest $request,$id){

    $ingreso=Ingreso::findorFail($id);
    $ingreso->descripcion=$request->get('descripcion');
    $ingreso->fecha=$request->get('fecha');
    $ingreso->valor=$request->get('valor');
    $ingreso->update();
    return Redirect::to('preescolar/ingreso');

	}

    public function destroy(){}

   
    /*

    select p.id,p.nombres,
(select a.adicional from adicionales a where p.id=a.alumno and a.adicional=2)
from persona p where p.tipo=2

    */

 

    public function nuevo(Request $Requests){

         $ingreso = new Ingreso;
         $ingreso->descripcion = $Requests->descripcion;
         $ingreso->fecha = $Requests->fecha;
         $ingreso->alumno = $Requests->alumno;
         $ingreso->valor = $Requests->valor;
         $ingreso->estado = '0';
         $ingreso->save();


      

         return response()->json(['msj'=>$Requests->descripcion]);

    }


    public function reporte(){

      
      $html = '<br><br><br><br><br><br>';

         $ingreso=DB::table('persona as p')
     ->join('ingreso as i','p.id','=','i.alumno')
     ->select('i.id as idin','i.descripcion as ides','i.valor as ival','i.fecha as ife','i.estado as iest','nombres','apellidos')->get();

        $datos=sizeof($ingreso);   

         PDF::SetTitle('Reporte_Ingreso');
        PDF::AddPage();
        

       $pos=0;

        //PDF::Image("img/logoreporte.png",10,10,30,30);

        if($datos>0){

        $html=$html.'<br> <table border="1" >';

        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Descripcion</td> <td  style="text-align:center">Valor</td> <td  style="text-align:center">Fecha</td> <td  style="text-align:center">Alumno</td><td  style="text-align:center">Estado</td> </tr>';

        for($i=0;$i<$datos;$i++){

       

        if($ingreso[$i]->iest==0) {$estado="Activo";}else{$estado="Inactivo";}


        $html=$html.'<tr> <td style="text-align:center">'.$ingreso[$i]->idin .'</td> <td  style="text-align:center">'. $ingreso[$i]->ides.'</td> <td  style="text-align:center">'. $ingreso[$i]->ival.'</td> <td  style="text-align:center">'. $ingreso[$i]->ife.'</td> <td  style="text-align:center">'. $ingreso[$i]->nombres." ".$ingreso[$i]->apellidos.'</td><td  style="text-align:center">'.$estado.'</td> </tr>';


        if($pos==42){
         
         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');
          $html='';
       

        }if($pos==43){

        PDF::AddPage();    

        $html = '<br><br><br><br><br><br>';   

        $html=$html.'<br> <table border="1" >';

        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Nombres</td> <td  style="text-align:center">Apellidos</td> <td  style="text-align:center">Direccion</td> <td  style="text-align:center">Estado</td> </tr>';


       $html=$html.'<tr> <td style="text-align:center">'.$ingreso[$i]->idin .'</td> <td  style="text-align:center">'. $ingreso[$i]->ides.'</td> <td  style="text-align:center">'. $ingreso[$i]->ival.'</td> <td  style="text-align:center">'. $ingreso[$i]->ife.'</td> <td  style="text-align:center">'. $ingreso[$i]->nombres." ".$ingreso[$i]->apellidos.'</td><td  style="text-align:center">'.$estado.'</td> </tr>';

        PDF::Image("img/logoreporte.png",10,10,30,30);



          }

          $pos++;
        
        }

        if(strlen($html)>0){

         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');

        }

        }
     

    PDF::Output('Reporte_Ingreso.pdf');

        

    }


}
