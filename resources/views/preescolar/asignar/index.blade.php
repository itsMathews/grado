@extends ('layouts.admin')
@section ('contenido')

<div class="row">

	<div class="col-lg-8 co-md-8 col-sm-8 col-xs-12">

		<h3>Asignar Adicionales </h3>

	 <div id="alertas" class="alert alert-info" style="display:none;"></div>

	</div>

</div>
 {{ csrf_field() }}
<div class="row">

   <div class="col-lg-4 co-md-4 col-sm-4 col-xs-12">

         	 <div class="form-group">
           <label for="nombre">Adicional</label>

           <select style="width:100%" id="sele" class="form-control">

             <option value="0">Seleccione</option>

           @foreach ($asignar as $asi)

          <option value="{{$asi->id}}">{{$asi->descripcion}}</option>

           @endforeach

           </select>
           </div>

   </div>



    <div class="col-lg-2 co-md-2 col-sm-2 col-xs-12">

        <div class="form-group">
           <label for="nombre">Fecha</label>

         <input type="date" name="fecha" id="fecha" class="form-control">

        </div>

    </div>

    <div class="col-lg-2 co-md-2 col-sm-2 col-xs-12">

        <div class="form-group">

          <label for="nombre">Valor</label>
         <input type="text" name="valor" id="valor" class="form-control">

        </div>

    </div>


     <div class="col-lg-1 co-md-1 col-sm-1 col-xs-12">



    <div class="form-group">

      <label for="nombre"style="display: block;">  &nbsp; </label>
                <button class="btn  btn-success  " id="btncrear">Crear</button>

    </div>

     </div>

     <div class="col-lg-1 co-md-1 col-sm-1 col-xs-12">



    <div class="form-group">

      <label for="nombre"style="display: block;">  &nbsp; </label>
                <button class="btn  btn-primary " id="btnactualizar">Actualizar</button>

    </div>

     </div>


 <input type="hidden" name="intid" id="intid" value="">

</div>

<div class="form-group">


                <button class="btn  btn-primary  btn-copy" id="btnc">Alumno</button>
                 <button class="btn btn-success btn-activite" id="btna">Curso</button>



  </div>


<div class="row">

   <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">



     {{ csrf_field() }}

     <div class="table-responsive">

      <table class="table table-striped table-bordered table-condensed table-hover">

          <thead class="bg-yellow-gradient">

           <th>Id</th>
           <th>nombre</th>
           <th>pellidos</th>
           <th>Curso</th>
           <th>Asignar</th>


         </thead>

          @foreach ($alumnos as $alu)





           <tr>


            <td>{{$alu->iden}}</td>
            <td>{{$alu->nombres}}</td>
            <td>{{$alu->apellidos}}</td>
            <td>{{$alu->descripcion}}</td>
            <td><input type="checkbox" name="" class="asignar" id="asig{{$alu->id}}" ></td>


           </tr>

            @endforeach

      </table>

     </div>

     {{ $asignar->render() }}

   </div>

</div>









<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>


<script>
        $(document).ready(function(){

          //alert($('input[name=_token]').val());
            //$('#alertas').show();


            $('#btncrear').prop('disabled',false);
            $('#btnactualizar').prop('disabled',false);



            function asigaciones(id,estado){
               $.ajax({
               type:'post',
               url:'asignar/cambiar',
                data:{'_token':$('input[name=_token]').val(),'id':id,'estado':estado,'fecha':$('#fecha').val(),'profesor':'1','tipo':'1','adicional': $('#intid').val()},
                success:function(data){
                console.log(data);},
              });
            }







             function buscarvalor(){

               sele=$('#sele').val();
               fecha=$('#fecha').val();


               if(sele>0 && fecha.length>0){
                $.ajax({
               type:'post',
               url:'asignar/valor',
                data:{'_token':$('input[name=_token]').val(),'sele':sele,'fecha':fecha},


                success:function(data){


                  $('#valor').val("");


                  console.log(data);

                  console.log(data['msj'].length);



                 for(i=0;i<data['rta'].length;i++){

                 id=data['rta'][i].id;
                 estado=data['rta'][i].adicional;

                 $('#asig'+id).prop("checked",false);
//#######################################################################################
								 if(estado>0){
                 $('#asig'+id).prop("checked",true);
							 				}
                 }




                if(data['msj'].length>0){

									$('#alertas').html('Adicionales asignados a esta fecha ');
                  $('#alertas').fadein(3000);

                   $('#intid').val(data['msj'][0].id);
                   $('#valor').val(data['msj'][0].valor);

                   $('#btnactualizar').prop('disabled',false);
                   $('#btncrear').prop('disabled',true);

                }else{
                  $('#intid').val("");
                 $('#alertas').html('No existe Informacion..Falta crearla ');
                 $('#alertas').fadeIn(3000);
                 $('#btncrear').prop('disabled',false);
                  $('#btnactualizar').prop('disabled',true);
                			}
              			},
              		});
              	}
             }
//######################################################################################################




             $('#btncrear').click( function(e){


             if($('#fecha').val().length>0 && $('#valor').val()>0) {

             $('#alertas').fadeOut(1000);

             $.ajax({
               type:'post',
               url:'asignar/nuevo',
                data:{'_token':$('input[name=_token]').val(),'fecha':$('#fecha').val(),'valor':$('#valor').val(),'adicional': $('#sele').val()},
                success:function(data){

                console.log(data);
                $('#intid').val(data['msj'][0].id);


              },
              });

             }else{

              $('#alertas').html('Falta Informacion');
              $('#alertas').fadeIn(3000);

             }

             });


             $('#sele').change( function(e){

              buscarvalor();

             });

              $('#fecha').change( function(e){

               buscarvalor();


            });






             $('.asignar').click( function(e){



              //lert( $('#sele').val());
                estado=0;

              if(!$(this).prop('checked'))
                estado=1;

               var id=($(this).attr('id'));
               id=id.substring(4,id.length);

               intid=$('#intid').val();

               valor=$('#valor').val();

               fecha=$('#fecha').val();


               if( $('#sele').val()==0 || valor.length==0 || fecha.length==0){
              e.preventDefault();
               }

               else{

                alert('asignando');
                asigaciones(id,estado);

                }

                //asigaciones(id,estado);





              });



            });

</script>


@endsection
