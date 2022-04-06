@extends ('layouts.admin')
@section ('contenido')

@include('preescolar.adicional.reporte')



<div class="row">

	<div class="col-lg-8 co-md-8 col-sm-8 col-xs-12">

		<h3>Listado de Adicionales  <a href="adicional/create"><button class="btn btn-success">Nuevo</button></a>  <button class="btn btn-danger btn-deletes" data-toggle="modal" data-target="#modaladicional" >Reporte</button>  </h3>

		@include('preescolar/adicional/search')

	</div>	

</div>


<div class="row">
	
   <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">

     <div id="alertas" class="alert alert-info"></div>

     {{ csrf_field() }}

   	 <div class="table-responsive">

   	 	<table class="table table-striped table-bordered table-condensed table-hover">
   	 	
                    <thead class="bg-yellow-gradient">
           
           <th>Id</th>
           <th>Fecha</th>
           <th>Descripcion</th>
           <th>Estado</th>
           <th>Opciones</th>

         </thead>
           @foreach ($adicional as $adi)
           <tr>

            
            <td>{{ $adi->id}}</td>
            <td>{{ $adi->fecha}}</td>
            <td>{{ $adi->descripcion}}</td>
                    
           	<td><span id="estado{{ $adi->id}}">
                  
                 <?php  if($adi->estado==0){
                    echo'Activo';

                }else{

                echo'Inactivo';
              }?>
              </span>

            </td>
           	<td>

              <div class="form-group">
              
              


                <a href="{{URL::action('AdicionalController@edit',$adi->id)}}"><button class="btn btn-info ">Editar</button></a>

                <button class="btn btn-success btn-activite" id="btna{{$adi->id}}">Activar</button>
                <button class="btn btn-danger btn-deletes" id="btnd{{$adi->id}}">Desactivar</button>

                

               

              
           
               

    

    </div>
      
            </td>

          
              
             
           



           </tr>
           @endforeach
   	 	</table>   	 	

   	 </div>

   	 {{ $adicional->render() }}

   </div>

</div>





<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>


<script>
        $(document).ready(function(){

          //alert($('input[name=_token]').val());
            $('#alertas').hide();

        //$("#modaladicional").modal('show');
            
            function cambiarestado(id,estado){

             $.ajax({
               type:'post',
               url:'adicional/cambiar',
                data:{'_token':$('input[name=_token]').val(),'id':id,'nestado':estado},
                success:function(data){

                if(estado==0){

                  $('#btna'+id).prop('disabled',true);
                  $('#btnd'+id).prop('disabled',false);

                }else{
                  
                  $('#btna'+id).prop('disabled',false);
                  $('#btnd'+id).prop('disabled',true);



                }




                 $('#estado'+id).html(data.msj);
                 $('#alertas').fadeIn();
                  $('#alertas').fadeOut(4000);

                },


              });


            }


             $('.btn-activite').click( function(e){
              e.preventDefault();
               var id=($(this).attr('id'));
               id=id.substring(4,id.length);
               cambiarestado(id,'0');
             
              });

            $('.btn-deletes').click( function(e){
              e.preventDefault();
              var id=($(this).attr('id'));
              id=id.substring(4,id.length);
              cambiarestado(id,'1');

              //var row= $(this).parents('tr');
              //var form= $(this).parents('form');
              //var url= form.attr('action');

              //row.hide();      
            });

            });

</script>


@endsection