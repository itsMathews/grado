<?php

namespace grado\Http\Controllers;

use Illuminate\Http\Request;

use grado\Http\Requests;
use grado\Persona;
use Illuminate\Support\Facades\Redirect;
use grado\Http\Requests\PersonaFormRequest;
use DB;
use PDF;

class PersonaController extends Controller
{

  public function __construct(){}

	public function index( Request $Requests){

    if($Requests){

     $query=trim($Requests->get('search'));//estado 1
     $persona=DB::table('persona')->where('nombres','LIKE','%'.$query.'%')->where('tipo','=','1')->orderBy('nombres','desc')->paginate(7);
     return view('preescolar.profesor.index',["persona"=>$persona,"search"=>$query]);


    }

	}

	public function create(){

    return view('preescolar.profesor.create');


	}

	public function store(PersonaFormRequest $request){

		$persona = new Persona;
		$persona->iden=$request->get('iden');
		$persona->nombres=$request->get('nombres');
		$persona->apellidos=$request->get('apellidos');
		$persona->direccion=$request->get('direccion');
		$persona->tel=$request->get('tel');
		$persona->tipo=$request->get('tipo');
		$persona->estado='0';
		$persona->save();
		return Redirect::to('preescolar/profesor');



	}

	public function show($id){

    return view("preescolar.profesor.show",["persona"=>Persona::findorFail($id)]);
  }

	public function edit($id){

    return view("preescolar.profesor.edit",["persona"=>Persona::findorFail($id)]);

	}

	public function update(PersonaFormRequest $request,$id){

    $persona=Persona::findorFail($id);
    $persona->iden=$request->get('iden');
    $persona->nombres=$request->get('nombres');
    $persona->apellidos=$request->get('apellidos');
    $persona->direccion=$request->get('direccion');
    $persona->tel=$request->get('tel');
    //$persona->descripcion=$request->get('tipo');
    //$persona->descripcion=$request->get('estado');
    $persona->update();
    return Redirect::to('preescolar/profesor');

	}

    public function destroy(PersonaFormRequest $request,$id){

     $persona=Persona::findorFail($id);
     $persona->estado=1;
     $persona->update();
     return Redirect::to('preescolar/profesor');

    }



   public function activar(Request $Requests){

     $id=$Requests->id;

     $persona=Persona::findorFail($id);
     $persona->estado=0;
     $persona->update();


    return response()->json(['msj'=>"salir"]);
    }


     public function desactivar(Request $Requests){

     $id=$Requests->id;

     $persona=Persona::findorFail($id);
     $persona->estado=1;
     $persona->update();


    return response()->json(['msj'=>"salir"]);
    }


    public function reporte(){


      $html = '<br><br><br><br><br><br>';

        $persona=DB::table('persona')->where('tipo','=','1')->get();

        $datos=sizeof($persona);

         PDF::SetTitle('Reporte_Profesores');
        PDF::AddPage();


       $pos=0;

        //PDF::Image("img/logoreporte.png",10,10,30,30);

        if($datos>0){

        $html=$html.'<br> <table border="1" >';

        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Iden</td> <td  style="text-align:center">Nombres</td> <td  style="text-align:center">Apellidos</td><td  style="text-align:center">Estado</td> </tr>';

        for($i=0;$i<$datos;$i++){



        if($persona[$i]->estado==0) {$estado="Activo";}else{$estado="Inactivo";}


        $html=$html.'<tr> <td style="text-align:center">'. ($i+1).'</td> <td  style="text-align:center">'. $persona[$i]->iden.'</td> <td  style="text-align:center">'. $persona[$i]->nombres.'</td> <td  style="text-align:center">'. $persona[$i]->apellidos.'</td><td  style="text-align:center">'.$estado.'</td> </tr>';


        if($pos==42){

         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');
          $html='';


        }if($pos==43){

        PDF::AddPage();

        $html = '<br><br><br><br><br><br>';

        $html=$html.'<br> <table border="1" >';

        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Nombres</td> <td  style="text-align:center">Apellidos</td> <td  style="text-align:center">Direccion</td> <td  style="text-align:center">Estado</td> </tr>';


        $html=$html.'<tr> <td style="text-align:center">'. ($i+1).'</td> <td  style="text-align:center">'. $persona[$i]->iden.'</td> <td  style="text-align:center">'. $persona[$i]->nombres.'</td> <td  style="text-align:center">'. $persona[$i]->apellidos.'</td><td  style="text-align:center">'.$estado.'</td> </tr>';

        PDF::Image("img/logoreporte.png",10,10,30,30);



          }

          $pos++;

        }

        if(strlen($html)>0){

         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');

        }

        }


    PDF::Output('Reporte_Profesores.pdf');



    }




}
