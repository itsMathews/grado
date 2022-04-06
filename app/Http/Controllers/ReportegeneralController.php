<?php

namespace grado\Http\Controllers;

use Illuminate\Http\Request;

use grado\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use grado\Http\Requests\PersonaFormRequest;
use DB;
use PDF;

class ReportegeneralController extends Controller
{
    
 
public function __construct(){}

	public function index( Request $Requests){

    if($Requests){

     $query=trim($Requests->get('search'));//estado 1 
     $alumno=DB::table('persona')->where('nombres','LIKE','%'.$query.'%')->where('tipo','=','2')->orderBy('nombres','desc')->paginate(7);
     return view('preescolar.reportegeneral.index',["alumno"=>$alumno,"search"=>$query]);


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

     
    return response()->json(['msj'=>"sallli"]);
    }


     public function desactivar(Request $Requests){

     $id=$Requests->id;

     $persona=Persona::findorFail($id);
     $persona->estado=1;
     $persona->update();

     
    return response()->json(['msj'=>"sallli"]);
    }



    public function filtro(Request $Requests){

        $alumno=$Requests->alumno;
        $feifil=$Requests->feifil;
        $feffil=$Requests->feffil;

           $qury="";
        if($alumno==0){
        $qury="select alumno,iden,nombre,sum(alimentacion) as alimentacion,sum(adicional) as adicional,sum(ingreso) as ingreso,(sum(ingreso)-sum(alimentacion)-sum(adicional)) as debe from vistageneral2 where fecha between '".$feifil."' and '".$feffil."' group by alumno ";
          }
         else{

     
        $qury="select alumno,iden,nombre,sum(alimentacion) as alimentacion,sum(adicional) as adicional,sum(ingreso) as ingreso,(sum(ingreso)-sum(alimentacion)-sum(adicional)) as debe from vistageneral2 where alumno='".$alumno."' and fecha between '".$feifil."' and '".$feffil."' group by alumno ";

         }


      $reporte=DB::select($qury);

     return response()->json(['msj'=>$reporte]);

    }


    public function reporte($id){

      $res=explode('-*-', $id);
      
      $html = '<br><br><br><br><br><br>';



       
        //$reporte = DB::table('vistageneral2')->whereBetween('fecha', array('2018-10-04', '2018-10-04'))->groupBy(DB::raw('alumno'))->get();

          if($res[0]==0){
    
          $reporte=DB::select("select alumno,iden,nombre,sum(alimentacion) as alimentacion,sum(adicional) as adicional,sum(ingreso) as ingreso from vistageneral2 where  fecha between '".$res[1]."' and '".$res[2]."' group by alumno ");

          }else{

          $reporte=DB::select("select alumno,iden,nombre,sum(alimentacion) as alimentacion,sum(adicional) as adicional,sum(ingreso) as ingreso from vistageneral2 where alumno='".$res[0]."' and fecha between '".$res[1]."' and '".$res[2]."' group by alumno ");

          }

     
                   
       

        $datos=sizeof($reporte);   

         PDF::SetTitle('Reporte_General');
        PDF::AddPage();
        

       $pos=0;

        //PDF::Image("img/logoreporte.png",10,10,30,30);

        if($datos>0){

        $html=$html.'<br> <table border="1" >';

        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Iden</td> <td  style="text-align:center">Nombre</td><td  style="text-align:center">Alimentacion</td>
           <td  style="text-align:center">Adicional</td> <td  style="text-align:center">Ingreso</td> </tr>';

        for($i=0;$i<$datos;$i++){

       

        


        $html=$html.'<tr> <td style="text-align:center">'. $reporte[$i]->alumno.'</td> <td  style="text-align:center">'. $reporte[$i]->iden.'</td> <td  style="text-align:center">'. $reporte[$i]->nombre.'</td> <td  style="text-align:center">'. $reporte[$i]->alimentacion.'</td><td  style="text-align:center">'.$reporte[$i]->adicional.'</td> 
            <td  style="text-align:center">'.$reporte[$i]->ingreso.'</td>  </tr>';


        if($pos==42){
         
         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');
          $html='';
       

        }if($pos==43){

        PDF::AddPage();    

        $html = '<br><br><br><br><br><br>';   

        $html=$html.'<br> <table border="1" >';

         $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Iden</td> <td  style="text-align:center">iden</td> <td  style="text-align:center">Nombre</td><td  style="text-align:center">Alimentacion</td>
           <td  style="text-align:center">Adicional</td> <td  style="text-align:center">Ingreso</td> </tr>';

        $html=$html.'<tr> <td style="text-align:center">'. $reporte[$i]->alumno.'</td> <td  style="text-align:center">'. $reporte[$i]->iden.'</td> <td  style="text-align:center">'. $reporte[$i]->nombre.'</td> <td  style="text-align:center">'. $reporte[$i]->alimentacion.'</td><td  style="text-align:center">'."".'</td> </tr>';

        PDF::Image("img/logoreporte.png",10,10,30,30);



          }

          $pos++;
        
        }

        if(strlen($html)>0){

         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');

        }

        }
     

    PDF::Output('Reporte_General.pdf');

        

    }
        



}
