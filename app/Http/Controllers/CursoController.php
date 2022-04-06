<?php

namespace grado\Http\Controllers;

use Illuminate\Http\Request;

use grado\Http\Requests;
use grado\Curso;
use Illuminate\Support\Facades\Redirect;
use grado\Http\Requests\CursoFormRequest;
use DB;
use PDF;




class CursoController extends Controller
{

	public function __construct(){}

	public function index( Request $Requests){

    if($Requests){

     $query=trim($Requests->get('search'));
     $curso=DB::table('curso')->where('descripcion','LIKE','%'.$query.'%')->orderBy('descripcion','desc')->paginate(7);
     return view('preescolar.curso.index',["curso"=>$curso,"search"=>$query]);


    }

	}

	public function create(){

    return view('preescolar.curso.create');


	}

	public function store(CursoFormRequest $request){

		$curso = new Curso;
		$curso->descripcion=$request->get('descripcion');
		$curso->save();
		return Redirect::to('preescolar/curso');



	}

	public function show($id){

    return view("preescolar.curso.show",["curso"=>Curso::findorFail($id)]);
  }

	public function edit($id){

    return view("preescolar.curso.edit",["curso"=>Curso::findorFail($id)]);

	}

	public function update(CursoFormRequest $request,$id){

    $curso=Curso::findorFail($id);
    $curso->descripcion=$request->get('descripcion');
    $curso->update();
    return Redirect::to('preescolar/curso');

	}

    public function destroy(){}


     public function reporte(){

      
      $html = '<br><br><br><br><br><br>';

        $curso=DB::table('curso')->get();

        $datos=sizeof($curso);   

         PDF::SetTitle('Reporte_Curso');
        PDF::AddPage();
        

       $pos=0;

        //PDF::Image("img/logoreporte.png",10,10,30,30);

        if($datos>0){

        $html=$html.'<br> <table border="1" >';

        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Descripcion</td></tr>';

        for($i=0;$i<$datos;$i++){

       

      

        $html=$html.'<tr> <td style="text-align:center">'. ($i+1).'</td> <td  style="text-align:center">'. $curso[$i]->descripcion.'</td> </tr>';


        if($pos==42){
         
         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');
          $html='';
       

        }if($pos==43){

        PDF::AddPage();    

        $html = '<br><br><br><br><br><br>';   

        $html=$html.'<br> <table border="1" >';


        $html=$html.'<tr> <td style="text-align:center">Id</td> <td  style="text-align:center">Descripcion</td></tr>';       


         $html=$html.'<tr> <td style="text-align:center">'. ($i+1).'</td> <td  style="text-align:center">'. $curso[$i]->descripcion.'</td> </tr>';


        PDF::Image("img/logoreporte.png",10,10,30,30);



          }

          $pos++;
        
        }

        if(strlen($html)>0){

         $html=$html.'</table>';
        PDF::writeHTML($html, true, false, true, false, '');

        }

        }
     

    PDF::Output('Reporte_Curso.pdf');

        

    }
        



    
}
