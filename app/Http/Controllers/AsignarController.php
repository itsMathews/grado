<?php

namespace grado\Http\Controllers;

use Illuminate\Http\Request;

use grado\Http\Requests;
use grado\Asignar;
use grado\Adicionales;
use grado\Adicionalvalor;
use Illuminate\Support\Facades\Redirect;
use grado\Http\Requests\AsignarFormRequest;
use DB;

class AsignarController extends Controller
{
    public function __construct(){}

	public function index( Request $Requests){

    if($Requests){

     $query=trim($Requests->get('search'));
     $asignar=DB::table('adicional')->orderBy('descripcion','desc')->paginate(7);

      $alumnos=DB::table('persona as p')
     ->join('cursoalumno as a','p.id','=','a.alumno')
     ->join('curso as c','c.id','=','a.curso')
     ->select('p.id','p.iden','p.nombres','p.apellidos','p.direccion','p.tel','p.estado','p.tipo','a.curso','c.descripcion')
     ->where('p.nombres','LIKE','%'.$query.'%')
     ->where('p.tipo','=','2')
     ->orderBy('p.nombres','desc')
     ->paginate(7);
     return view('preescolar.asignar.index',["asignar"=>$asignar,"search"=>$query,"alumnos"=>$alumnos]);


    }

	}

	public function create(){

    return view('preescolar.aignar.create');


	}

	public function store(AsignarFormRequest $request){

		$asignar = new Asignar;
		$asignar->fecha=$request->get('fecha');
		$asignar->descripcion=$request->get('descripcion');
		$asignar->valor=$request->get('valor');
		$asignar->estado='0';
		$asignar->save();
		return Redirect::to('preescolar/asignar');

	}

	public function show($id){

    return view("preescolar.asignar.show",["asignar"=>Asignar::findorFail($id)]);
  }

	public function edit($id){

    return view("preescolar.asignar.edit",["asignar"=>Asignar::findorFail($id)]);

	}

	public function update(AsignarFormRequest $request,$id){

    $asignar=Asignar::findorFail($id);
    $asignar->descripcion=$request->get('descripcion');
    $asignar->fecha=$request->get('fecha');
    $asignar->valor=$request->get('valor');
    $asignar->update();
    return Redirect::to('preescolar/asignar/');

	}

    public function destroy(){}

    public function changeStatus(Request $Requests,$id) 
    {

        if($Requests->ajax()){

       // $id ='1'; //Input::get('id');

        $asignar = Asignar::findOrFail($id);
        $asignar->estado = '1';
        $asignar->save();

        return response()->json(['msj'=>'entre...']);


        }
        
    }

    /*

    select p.id,p.nombres,
(select a.adicional from adicionales a where p.id=a.alumno and a.adicional=2)
from persona p where p.tipo=2

    */


     public function valor(Request $Requests) 
    {

       $vid=DB::select('SELECT * FROM adicionalvalor  where adicional = ? and fecha=? ', array($Requests->sele,$Requests->fecha));

       $query="";

      if(count($vid)>0){
        
        $adi=$vid[0]->id;


       $query="select p.id,case when (select a.adicional from adicionales a where p.id=a.alumno and a.adicional=".$adi.") is null then 0 ELSE (select a.adicional from adicionales a where p.id=a.alumno and a.adicional=".$adi.") end as adicional from persona p where p.tipo=2";
      }else{

        $query="select id,'0' as adicional from persona where tipo=2";
      }

       $rtas=DB::select( $query);


      return response()->json(['msj'=> $vid,'rta'=>$rtas]);


    }

     public function cambiar(Request $Requests) 
    {

        //$id =Input::get('id');

       $id=$Requests->id;
       $estado=$Requests->estado;


       $rta="mal";




        if($estado==0){
        $adicionales = new Adicionales;
        $adicionales->profesor=$Requests->profesor;
        $adicionales->alumno=$Requests->id;
        $adicionales->adicional=$Requests->adicional;
        $adicionales->tipo=$Requests->tipo;
        $adicionales->save();
        }else
        {

           $vid=DB::select('SELECT (id) as id FROM adicionales  where alumno = ? and adicional=?  and tipo=?', array($Requests->id,$Requests->adicional,1));



        if(count($vid)>0){

          $adicionales = Adicionales::findOrFail($vid[0]->id);
          $adicionales->delete();

       }

       ///SELECT ad.id,ad.descripcion,p.iden
       //from adicional ad,persona p where p.tipo=2 order by ad.id asc
        

        }

      
        
        return response()->json(['msj'=>$rta]);

   
      
        
    }


    public function asignar(){

    return view('preescolar.adicional.asignar');

    }


    public function nuevo(Request $Requests){

         $adicionalvalor = new Adicionalvalor;
         $adicionalvalor->adicional = $Requests->adicional;
         $adicionalvalor->fecha = $Requests->fecha;
         $adicionalvalor->valor = $Requests->valor;
         $adicionalvalor->save();


         $rtas=DB::select('SELECT  id FROM adicionalvalor  where adicional = ? and  fecha=?', array($Requests->adicional,$Requests->fecha));

      

         return response()->json(['msj'=>$rtas]);

    }


}
