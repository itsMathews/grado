<?php

namespace grado\Http\Controllers;

use Illuminate\Http\Request;

use grado\Http\Requests;
use grado\Compras;
use Illuminate\Support\Facades\Redirect;
use grado\Http\Requests\ComprasFormRequest;
use DB;
use PDF;




class ComprasController extends Controller
{
    
     public function __construct(){}

	public function index( Request $Requests){

    if($Requests){

     $query=trim($Requests->get('search'));
     $compras=DB::table('compras')->orderBy('descripcion','desc')->paginate(7);      
     return view('preescolar.compras.index',["compras"=>$compras,"search"=>$query]);

return view('preescolar.compras.index',["compras"=>$compras,"search"=>$query]);

    }

	}

	public function create(){

    return view('preescolar.compras.create');


	}

	public function store(ComprasFormRequest $request){

		$compras = new Compras;
		$compras->fecha=$request->get('fecha');
		$compras->descripcion=$request->get('descripcion');
		$compras->valor=$request->get('valor');
		$compras->estado='0';
		$compras->save();
		return Redirect::to('preescolar/compras');

	}

	public function show($id){

    return view("preescolar.compras.show",["compras"=>Compras::findorFail($id)]);
  }

	public function edit($id){

    return view("preescolar.compras.edit",["compras"=>Compras::findorFail($id)]);

	}

	public function update(ComprasFormRequest $request,$id){

    $compras=Compras::findorFail($id);
    $compras->descripcion=$request->get('descripcion');
    $compras->fecha=$request->get('fecha');
    $compras->valor=$request->get('valor');
    $compras->update();
    return Redirect::to('preescolar/compras');

	}

    public function destroy(){}

   
    /*

    select p.id,p.nombres,
(select a.adicional from adicionales a where p.id=a.alumno and a.adicional=2)
from persona p where p.tipo=2

    */

 

    public function nuevo(Request $Requests){

         $compras = new Compras;
         $compras->descripcion = $Requests->descripcion;
         $compras->fecha = $Requests->fecha;
         $compras->valor = $Requests->valor;
         $compras->estado = '0';
         $compras->save();


      

         return response()->json(['msj'=>$Requests->descripcion]);

    }


     public function reporte(){

      
      $html = '<br><br><br><br><br><br>';

        $compras=DB::table('compras')->get();

        $datos=sizeof($compras);   

         PDF::SetTitle('Reporte_Compras');
        PDF::AddPage();
        

       $pos=0;

        //PDF::Image("img/logoreporte.png",10,10,30,30);

        if($datos>0){

        $html=$html.'<br> <table border="1" >';

        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Descripcion</td> <td  style="text-align:center">Fecha</td> <td  style="text-align:center">Valor</td><td  style="text-align:center">Estado</td> </tr>';

        for($i=0;$i<$datos;$i++){

       /* $html=$html.'<tr> <td  style="text-align:center"> '.$i.'</td> ';
        $html=$html.'<td  style="text-align:center"> '."2".' </td> ';
        $html=$html.'<td  style="text-align:center"> '."3".' </td> ';
        $html=$html.'<td  style="text-align:center"> '."44".' </td> ';
        $html=$html.'<td  style="text-align:center"> '."5".' </td> ';
        $html=$html.'<td  style="text-align:center"> '."6".' </td> </tr> ';*/

        if($compras[$i]->estado==0) {$estado="Activo";}else{$estado="Inactivo";}


        $html=$html.'<tr> <td style="text-align:center">'.$compras[$i]->id.'</td> <td  style="text-align:center">'. $compras[$i]->descripcion.'</td> <td  style="text-align:center">'.$compras[$i]->fecha.'</td> <td  style="text-align:center">'.$compras[$i]->valor.'</td><td  style="text-align:center">'.$estado.'</td> </tr>';


        if($pos==42){
         
         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');
          $html='';
       

        }if($pos==43){

        PDF::AddPage();    

        $html = '<br><br><br><br><br><br>';   

        $html=$html.'<br> <table border="1" >';

         $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Descripcion</td> <td  style="text-align:center">Fecha</td> <td  style="text-align:center">Valor</td><td  style="text-align:center">Estado</td> </tr>';

          $html=$html.'<tr> <td style="text-align:center">'.$compras[$i]->id.'</td> <td  style="text-align:center">'. $compras[$i]->descripcion.'</td> <td  style="text-align:center">'.$compras[$i]->fecha.'</td> <td  style="text-align:center">'.$compras[$i]->valor.'</td><td  style="text-align:center">'.$estado.'</td> </tr>';

        PDF::Image("img/logoreporte.png",10,10,30,30);



          }

          $pos++;
        
        }

        if(strlen($html)>0){

         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');

        }

        }
     

    PDF::Output('Reporte_Compras.pdf');

        

    }



}
