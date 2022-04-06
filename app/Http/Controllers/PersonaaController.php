<?php

namespace grado\Http\Controllers;

use Illuminate\Http\Request;

use grado\Http\Requests;
use grado\Personaa;
use grado\CursoAlumno;
use Illuminate\Support\Facades\Redirect;
use grado\Http\Requests\PersonaaFormRequest;
use DB;
use PDF;

class PersonaaController extends Controller
{
   public function __construct(){}

	public function index( Request $Requests){

    if($Requests){

     $query=trim($Requests->get('search'));//estado 1
     $personaa=DB::table('persona as p')
     ->join('cursoalumno as a','p.id','=','a.alumno')
     ->join('curso as c','c.id','=','a.curso')
     ->select('p.id','p.iden','p.nombres','p.apellidos','p.direccion','p.tel','p.estado','p.tipo','a.curso','c.descripcion')
     ->where('p.nombres','LIKE','%'.$query.'%')
     ->where('p.tipo','=','2')
     ->orderBy('p.nombres','desc')
     ->paginate(7);


     return view('preescolar.alumno.index',["personaa"=>$personaa,"search"=>$query]);


    }

	}

	public function create(){

    return view('preescolar.alumno.create');


	}

	public function store(PersonaaFormRequest $request){

		$personaa = new Personaa;
		$personaa->iden=$request->get('iden');
		$personaa->nombres=$request->get('nombres');
		$personaa->apellidos=$request->get('apellidos');
		$personaa->direccion=$request->get('direccion');
		$personaa->tel=$request->get('tel');
        $personaa->tipo='2';
		$personaa->estado='0';
		$personaa->save();

        $vid=DB::select('SELECT MAX(id) as id FROM persona');

  /*     Running An Insert Statement
DB::insert('insert into users (id, name) values (?, ?)', array(1, 'Dayle'));
Running An Update Statement
DB::update('update users set votes = 100 where name = ?', array('John'));
Running A Delete Statement
DB::delete('delete from users');*/


        $cursoalumno = new CursoAlumno;
        $cursoalumno->curso='1';
        $cursoalumno->alumno=$vid[0]->id;
        $cursoalumno->save();





		return Redirect::to('preescolar/alumno');



	}

	public function show($id){

    return view("preescolar.alumno.show",["personaa"=>Personaa::findorFail($id)]);
  }

	public function edit($id){

   $curso=DB::table('curso')->get();
   $idcurso=DB::table('cursoalumno')->where('alumno','=',$id)->get();

    return view("preescolar.alumno.edit",["personaa"=>Personaa::findorFail($id),"curso"=>$curso,"idcurso"=>$idcurso[0]->curso]);

	}

	public function update(PersonaaFormRequest $request,$id){

    $personaa=Personaa::findorFail($id);
    $personaa->iden=$request->get('iden');
    $personaa->nombres=$request->get('nombres');
    $personaa->apellidos=$request->get('apellidos');
    $personaa->direccion=$request->get('direccion');
    $personaa->tel=$request->get('tel');
    //$persona->descripcion=$request->get('tipo');
    //$persona->descripcion=$request->get('estado');
    $personaa->update();
    return Redirect::to('preescolar/alumno');

	}

    public function destroy(PersonaaFormRequest $request,$id){

     $personaa=Personaa::findorFail($id);
     $personaa->estado=1;
     $personaa->update();
     return Redirect::to('preescolar/alumno');

    }

    public function activar(Request $Requests){

     $id=$Requests->id;

     $persona=Personaa::findorFail($id);
     $persona->estado=0;
     $persona->update();


    return response()->json(['msj'=>"sallli"]);
    }


     public function desactivar(Request $Requests){

     $id=$Requests->id;

     $persona=Personaa::findorFail($id);
     $persona->estado=1;
     $persona->update();


    return response()->json(['msj'=>"sallli"]);
    }



    public function reporte(){


      $html = '<br><br><br><br><br><br>';

        $persona=DB::table('persona')->where('tipo','=','2')->get();

        $datos=sizeof($persona);

        PDF::SetTitle('Reporte_Alumnos');
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

    PDF::Output('Reporte_Alumnos.pdf');

    }






}
