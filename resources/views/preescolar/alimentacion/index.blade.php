@extends ('layouts.admin')
@section ('contenido')





{{ csrf_field() }}


<div id="alertas2" class="alert alert-info" style="display:none;"></div>

<div class="row">

  <div class="col-lg-8 co-md-8 col-sm-8 col-xs-12">

    <h3>Crear Menu</h3>

    

  </div>  

</div>



<div class="row"> <!-- crear menu -->

  <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">Menu Nuevo</label>
    <input type="text" name="descripcion" id="descripcion" class="form-control"  value="" placeholder="Menu">
    </div>

    </div>

    <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">Merienda 1</label>
    <input type="text" name="meriendanueva1" id="meriendanueva1" class="form-control"  value="" placeholder="valor">
    </div>

   </div>

   <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">Merienda 2</label>
    <input type="text" name="meeriendanueva2" id="meriendanueva2" class="form-control"  value="" placeholder="valor" >
    </div>

   </div>

   <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">Almuero</label>
    <input type="text" name="almuerzonuevo" id="almuerzonuevo" class="form-control"  value="" placeholder="valor" >
    </div>

   </div>


   <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">


    <button class="btn btn-primary" id="btncrear" type="sumit" style="
    top: 25px;  position: relative;">Crear</button>

   </div>


</div>

<div class="row">

  <div class="col-lg-8 co-md-8 col-sm-8 col-xs-12">

    <h3>Asignar Menu</h3>

    

  </div>  

</div>



<div class="row">
  


  <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">
   <label for="descripcion">Menu</label>
  <select style="width:100%" id="menu" class="form-control">

           <option value="0">Seleccione</option>

           @foreach ($menu as $men)

           <option value="{{$men->id}}">{{$men->descripcion}}</option>

             
           @endforeach
          
           </select> 

 </div>


   <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">Fecha</label>
    <input type="date" name="fecha" id="fecha" class="form-control"  value="" placeholder="valor">
    </div>

   </div>
   

   <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">Merienda 1</label>
    <input type="text" name="merienda1" id="merienda1" class="form-control"  value="" placeholder="valor" disabled>
    </div>

   </div>

   <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">Merienda 2</label>
    <input type="text" name="meerienda2" id="merienda2" class="form-control"  value="" placeholder="valor" disabled >
    </div>

   </div>

   <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">Almuero</label>
    <input type="text" name="almuerzo" id="almuerzo" class="form-control"  value="" placeholder="valor" disabled>
    </div>

   </div>

 

 </div>

<div id="alertas" class="alert alert-info" style="display:none;"></div>

<div class="row">

	<div class="col-lg-8 co-md-8 col-sm-8 col-xs-12">

		<h3>Listado de Alimentacion Por Alumno  </h3>

		

	</div>	

</div>



<div class="row">
	
   <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">

   	 <div class="table-responsive">

   	 	<table class="table table-striped table-bordered table-condensed table-hover">
   	 	
                    <thead class="bg-yellow-gradient">
           
           <th>Iden</th>
           <th>Alumno</th>
           <th>Menu</th>
           <th>Merienda 1</th>
           <th>Merienda 2</th>
           <th>Almuerzo</th>
          

         </thead>
          

          @foreach ($alimentacion as $ali)
           <tr>           
           	
           <td>{{ $ali->iden}}</td>
           <td>{{ $ali->nombres."".$ali->apellidos}}</td>
           <td><span id="men{{$ali->id}}"></span></td>

           <td><input type="checkbox" name="" class="alimento" id="me1v{{$ali->id}}" ></td></td>
           <td><input type="checkbox" name="" class="alimento" id="me2v{{$ali->id}}" ></td></td>
           <td><input type="checkbox" name="" class="alimento" id="almv{{$ali->id}}" ></td></td>
                      	
           </tr>

            @endforeach
          
   	 	</table>   	 	

   	 </div>

   	 {{ $alimentacion->render() }}

   </div>

</div>






<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>


<script>
        $(document).ready(function(){


        function valor(){

          

         if ($('#fecha').val().length>0){

             // alert("entrando a ajax valor...");

         $.ajax({
               type:'post',
               url:'alimentacion/valor',
                data:{'_token':$('input[name=_token]').val(),"fecha":$('#fecha').val()},
                success:function(data){

                console.log(data);
                //alert(data);
                //$('#intid').val(data['msj'][0].id);

                if(data['rta'].length>0){
                for(i=0;i<data['rta'].length;i++){

                   id=data['rta'][i].alumno;
                   almu=data['rta'][i].almuerzo;
                   mer1=data['rta'][i].merienda1;
                   mer2=data['rta'][i].merienda2;
                   menu=data['rta'][i].descripcion;
                                  

                  $('#men'+id).html(menu);
                   
                   if(mer1==1){ $('#me1v'+id).prop("checked",true);}
                   if(mer2==1){ $('#me2v'+id).prop("checked",true);}
                   if(almu==1){ $('#almv'+id).prop("checked",true);}


                }}else{


                  for(i=0;i<data['msj'].length;i++){

                   id=data['msj'][i].id;
                  
                                  
                   
                    $('#me1v'+id).prop("checked",false);
                    $('#me2v'+id).prop("checked",false);
                    $('#almv'+id).prop("checked",false);

                     $('#men'+id).html('');


                }



                }








                 },
              }); 
        }

      }

       valor();

          $('#fecha').change( function(e){

           //alert("cambie de fecha..");
           valor();

          });

            $('#menu').change( function(e){

          // alert("cambie menu..");
           valor();

          });








            $('#btncrear').click( function(e){

             


              if($('#descripcion').val().length>0 && $('#meriendanueva1').val().length>0 && $('#meriendanueva2').val().length>0 && $('#almuerzonuevo').val().length>0){

                 $('#alertas2').fadeOut(1000); 


                 //alert("creo el menu");


                 $.ajax({
               type:'post',
               url:'alimentacion/crearmenu',
                data:{'_token':$('input[name=_token]').val(),"descripcion":$('#descripcion').val(),"meriendanueva1":$('#meriendanueva1').val(),"meriendanueva2":$('#meriendanueva2').val(),"almuerzonuevo":$('#almuerzonuevo').val()},
                success:function(data){

                console.log(data);
                //$('#intid').val(data['msj'][0].id);

                  location.reload();
         
                 },
              }); 

                
            }else{

             

              $('#alertas2').html('Falta Informacion');
              $('#alertas2').fadeIn(3000);

            }


          });

          
          $('.alimento').click( function(e){    


          var id=($(this).attr('id'));
            //alert(id);

            id=id.substring(4,id.length);
            //alert($('#menu').val());



             if($('#menu').val()>0 && $('#fecha').val().length>0) {     

             $('#alertas').fadeOut(1000); 

             //alert("Entre alimentacion..");


                merienda1=1;

              if(!$('#me1v'+id).prop('checked'))
                merienda1=0;


               merienda2=1;

              if(!$('#me2v'+id).prop('checked'))
                merienda2=0;

                 almuerzo=1;

              if(!$('#almv'+id).prop('checked'))
                almuerzo=0;

             //merienda1=$('#me1v'+id).val(); 
             //merienda2=$('#me2v'+id).val();
             //almuerzo=$('#almv'+id).val(); 

          

                         
             $.ajax({
               type:'post',
               url:'alimentacion/cambiar',
                data:{'_token':$('input[name=_token]').val(),"profesor":"1","fecha":$('#fecha').val(),"alumno":id,"menu":$('#menu').val(),"merienda1": merienda1,"merienda2": merienda2,"almuerzo": almuerzo},
                success:function(data){

                console.log(data);
                //$('#intid').val(data['msj'][0].id);


                
                 
                

                  



                 },
              }); 

             }else{

                e.preventDefault();
              $('#alertas').html('Falta Informacion');
              $('#alertas').fadeIn(3000);


             }

             });
              
            

            });

</script>


@endsection