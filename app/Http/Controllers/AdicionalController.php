<?php

namespace grado\Http\Controllers;

use Illuminate\Http\Request;

use grado\Http\Requests;
use grado\Adicional;
use Illuminate\Support\Facades\Redirect;
use grado\Http\Requests\AdicionalFormRequest;
use DB;
use PDF;

class AdicionalController extends Controller
{
    /*public function __construct(){

  $this->middleware('auth');

    }*/

	public function index( Request $Requests){

    if($Requests){      



     $query=trim($Requests->get('search'));
     $adicional=DB::table('adicional')->where('descripcion','LIKE','%'.$query.'%')->orderBy('descripcion','desc')->paginate(7);
     return view('preescolar.adicional.index',["adicional"=>$adicional,"search"=>$query]);


    }

	}

	public function create(){

    return view('preescolar.adicional.create');


	}

	public function store(AdicionalFormRequest $request){

		$adicional = new Adicional;
		$adicional->fecha=$request->get('fecha');
		$adicional->descripcion=$request->get('descripcion');
		$adicional->estado='0';
		$adicional->save();
		return Redirect::to('preescolar/adicional');

	}

	public function show($id){

    return view("preescolar.adicional.show",["adicional"=>Adicional::findorFail($id)]);
  }

	public function edit($id){

    return view("preescolar.adicional.edit",["adicional"=>Adicional::findorFail($id)]);

	}

	public function update(AdicionalFormRequest $request,$id){

    $adicional=Adicional::findorFail($id);
    $adicional->descripcion=$request->get('descripcion');
    $adicional->fecha=$request->get('fecha');
    $adicional->update();
    return Redirect::to('preescolar/adicional');

	}

    public function destroy(){}

    public function changeStatus(Request $Requests,$id) 
    {

        if($Requests->ajax()){

       // $id ='1'; //Input::get('id');

        $adicional = Adicional::findOrFail($id);
        $adicional->estado = '1';
        $adicional->save();

        return response()->json(['msj'=>'entre...']);


        }
        
    }


     public function cambiar(Request $Requests) 
    {

        //$id =Input::get('id');

       $id=$Requests->id;
       $estdo=$Requests->nestado;


       $adicional = Adicional::findOrFail($id);
        $adicional->estado = $estdo;
        $adicional->save();

        $rta="Activo";

        if($estdo==1){

         $rta="Inactivo"; 
        }

        return response()->json(['msj'=>$rta]);

   
      
        
    }


    public function asignar(){

    return view('preescolar.adicional.asignar');

    }


    public function reporte(){

        $html = '<br><br><br><br><br><br>';

        $adicional=DB::table('adicional')->get();

        $datos=sizeof($adicional);   

        PDF::SetTitle('Reporte_Adicional');
        PDF::AddPage();
        

       $pos=0;

        //PDF::Image("img/logoreporte.png",10,10,30,30);

        if($datos>0){

        $html=$html.'<br> <table border="1" >';

        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Fecha</td> <td  style="text-align:center">Descripcion</td> <td  style="text-align:center">Estado</td> </tr>';

        for($i=0;$i< $datos;$i++){


         if($adicional[$i]->estado==0){ $estado="Activo";}else{$estado="Inactivo";}


        $html=$html.'<tr> <td  style="text-align:center"> '.$i.'</td> ';
        $html=$html.'<td  style="text-align:center"> '.$adicional[$i]->fecha.' </td> ';
        $html=$html.'<td  style="text-align:center"> '.$adicional[$i]->descripcion.' </td> ';
        $html=$html.'<td  style="text-align:center"> '.$estado.' </td> </tr> ';


        if($pos==42){
         
         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');
          $html='';
       

        }if($pos==43){

        PDF::AddPage();    

        $html = '<br><br><br><br><br><br>';   

        $html=$html.'<br> <table border="1" >';

        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Fecha</td> <td  style="text-align:center">Descripcion</td> <td  style="text-align:center">Estado</td> </tr>';


        $html=$html.'<tr> <td  style="text-align:center"> '.$i.'</td> ';
        $html=$html.'<td  style="text-align:center"> '.$adicional[$i]->fecha.' </td> ';
        $html=$html.'<td  style="text-align:center"> '.$adicional[$i]->descripcion.' </td> ';
        $html=$html.'<td  style="text-align:center"> '.$adicional[$i]->estado.' </td> </tr> ';

        PDF::Image("img/logoreporte.png",10,10,30,30);



          }

          $pos++;
        
        }

        if(strlen($html)>0){

         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');

        }

        }
     

        



    PDF::Output('hello_world.pdf');

  

    }



}
