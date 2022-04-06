<?php

namespace grado\Http\Controllers;

use Illuminate\Http\Request;

use grado\Http\Requests;
use grado\Alimentacion;
use grado\Menu;
use Illuminate\Support\Facades\Redirect;
use grado\Http\Requests\AlimentacionFormRequest;
use DB;

class AlimentacionController extends Controller
{
     public function __construct(){}

	public function index( Request $Requests){

    if($Requests){

     $query=trim($Requests->get('search'));     
     $alimentacion=DB::table('persona as p')->where('p.tipo','=','2')
     ->where('p.estado','=','0')   
     ->orderBy('p.nombres','desc')
     ->paginate(7);

     $query=trim($Requests->get('search'));     
     $menu=DB::table('menu')
     ->orderBy('descripcion','desc')
     ->paginate(7);

     
     return view('preescolar.alimentacion.index',["alimentacion"=>$alimentacion,"search"=>$query,"menu"=>$menu]);


    }

	}

	public function create(){

    return view('preescolar.alimentacion.create');


	}

	public function store(AlimentacionFormRequest $request){

		$alimentacion = new Alimentacion;
		$alimentacion ->fecha=$request->get('fecha');
		$alimentacion ->descripcion=$request->get('descripcion');
		$alimentacion ->valor=$request->get('valor');
		$alimentacion ->estado='0';
		$alimentacion ->save();
		return Redirect::to('preescolar/alimentacion');

	}

	public function show($id){

    return view("preescolar.alimentacion.show",["alimentacion"=>Alimentacion::findorFail($id)]);
  }

	public function edit($id){

    return view("preescolar.alimentacion.edit",["alimentacion"=>Alimentacion::findorFail($id)]);

	}

	public function update(AlimentacionFormRequest $request,$id){

        $alimentacion=Alimentacion::findorFail($id);
        $alimentacion->profesor=$Requests->profesor;
        $alimentacion->fecha=$Requests->fecha;
        $alimentacion->alumno=$Requests->id;
        $alimentacion->menu=$Requests->menu;
        $alimentacion->merienda1=$Requests->merienda1;
        $alimentacion->merienda2=$Requests->merienda2;
        $alimentacion->almuerzo=$Requests->almuerzo;
        $alimentacion->update();
    return Redirect::to('preescolar/alimentacion');

	}

    public function destroy(){}

    
    /*

    select p.id,p.nombres,
(select a.adicional from adicionales a where p.id=a.alumno and a.adicional=2)
from persona p where p.tipo=2

    */

    
     public function valor(Request $Requests) 
    {


       if($Requests){
      $fecha = $Requests->fecha;

      //se debe enviar deos sql uno con informacion 
      //otro si no existe informacion..
      //retorna la totalidad de aluos activos
      $alumnos=DB::select("select * from persona where tipo='2' and estado='0'"); 

      $rtas="";

      if($fecha){

       $query="select *,descripcion from alimentacion a,menu m where a.fecha='$fecha' and m.id=a.menu";
     

       $rtas=DB::select( $query);

   }


      return response()->json(['msj'=> $alumnos,'rta'=>$rtas]);

      }

    }

     public function cambiar(Request $Requests) 
    {

        //$id =Input::get('id');

       

       $rta="mal";

        

          $vid=DB::select('SELECT (id) as id FROM alimentacion  where alumno = ? and fecha=?', array($Requests->alumno,$Requests->fecha));



      if(count($vid)>0){ //actualizo la alimentacion

        $alimentacion=Alimentacion::findorFail($vid[0]->id);
        $alimentacion->profesor=$Requests->profesor;        
        $alimentacion->menu=$Requests->menu;
        $alimentacion->merienda1=$Requests->merienda1;
        $alimentacion->merienda2=$Requests->merienda2;
        $alimentacion->almuerzo=$Requests->almuerzo;
        $alimentacion->update();        

       }else

       {// creo la aimentacion

        $alimentacion = new Alimentacion;
        $alimentacion->profesor=$Requests->profesor;
        $alimentacion->fecha=$Requests->fecha;
        $alimentacion->alumno=$Requests->alumno;
        $alimentacion->menu=$Requests->menu;
        $alimentacion->merienda1=$Requests->merienda1;
        $alimentacion->merienda2=$Requests->merienda2;
        $alimentacion->almuerzo=$Requests->almuerzo;
        $alimentacion->save();


       }   
        
        return response()->json(['msj'=>$alimentacion]);   
      
        
    }


    public function asignar(){

    return view('preescolar.adicional.asignar');

    }

    public function crearmenu(Request $Requests){


    	$menu = new Menu;
    	 $menu->descripcion = $Requests->descripcion;
         $menu->vmer1 = $Requests->meriendanueva1;
         $menu->vmer2 = $Requests->meriendanueva2;
         $menu->valm = $Requests->almuerzonuevo;
         $menu->save();


       return response()->json(['msj'=>"sali........."]);
   

    }


    public function nuevo(Request $Requests){

         $adicionalvalor = new Adicionalvalor;
         $adicionalvalor->adicional = $Requests->adicional;
         $adicionalvalor->meriendanueva1 = $Requests->meriendanueva1;
         $adicionalvalor->meriendanueva2 = $Requests->meriendanueva2;
         $adicionalvalor->save();


         $rtas=DB::select('SELECT  id FROM adicionalvalor  where adicional = ? and  fecha=?', array($Requests->adicional,$Requests->fecha));

      

         return response()->json(['msj'=>$rtas]);

    }
}
