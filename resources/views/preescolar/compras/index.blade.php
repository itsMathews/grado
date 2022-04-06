@extends ('layouts.admin')
@section ('contenido')
@include('preescolar.compras.reporte')



<div id="alertas" class="alert alert-info" style="display:none;"></div>


{{ csrf_field() }}


<div class="row">
  
    <div class="col-lg-4 co-md-4 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">Descripcion</label>
    <input type="text" name="descripcion"  id="descripcion" class="form-control"  value="" placeholder="Descripcion">
    </div>

   </div>

   <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">valor</label>
    <input type="text" name="valor" id="valor" class="form-control"  value="" placeholder="valor">
    </div>

   </div>

   <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">fecha</label>
    <input type="date" name="fecha" id="fecha" class="form-control"  value="" >
    </div>

   </div>

   <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">


    <button class="btn btn-primary" id="btncrear" type="sumit" style="
    top: 25px;  position: relative;">Guardar</button>

   </div>
 

 </div>



<div class="row">

	<div class="col-lg-8 co-md-8 col-sm-8 col-xs-12">

		<h3>Listado de Compras <button class="btn btn-danger btn-deletes" data-toggle="modal" data-target="#modalcompras" >Reporte</button>  </h3>

		@include('preescolar/compras/search')

	</div>	

</div>



<div class="row">
	
   <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">

   	 <div class="table-responsive">

   	 	<table class="table table-striped table-bordered table-condensed table-hover">
   	 	
                    <thead class="bg-yellow-gradient">
           
           <th>Id</th>
           <th>Descripcion</th>
           <th>Valor</th>
           <th>Fecha</th>
           <th>Estado</th>
           <th>Opciones</th>

         </thead>
           @foreach ($compras as $com)
           <tr>
           	<td>{{ $com->id}}</td>
           	<td>{{ $com->descripcion}}</td>
            <td>{{ $com->valor}}</td>
            <td>{{ $com->fecha}}</td>
            <td> 
              <span id="estado{{ $com->id}}">
                  
                 <?php  if($com->estado==0){
                    echo'Activo';

                }else{

                echo'Inactivo';
              }?>
              </span>


            </td>
           	<td>

               <div class="form-group">
                            
             <a href="{{URL::action('ComprasController@edit',$com->id)}}"><button class="btn btn-info ">Editar</button></a>

               <button class="btn btn-success btn-activite" id="btna{{$com->id}}">Activar</button>
                <button class="btn btn-danger btn-deletes" id="btnd{{$com->id}}">Desactivar</button>

              </div>

            </td>
           </tr>
           @endforeach
   	 	</table>   	 	

   	 </div>

   	 {{ $compras->render() }}

   </div>

</div>






<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>


<script>
        $(document).ready(function(){

          
          $('#btncrear').click( function(e){      


             if($('#descripcion').val().length>0 && $('#valor').val() && $('#fecha').val().length>0 >0) {     

             $('#alertas').fadeOut(1000); 

             alert($('input[name=_token]').val());
             alert($('#descripcion').val());
             alert($('#valor').val());
             alert($('#fecha').val());

             
             $.ajax({
               type:'post',
               url:'compras/nuevo',
                data:{'_token':$('input[name=_token]').val(),"descripcion":$('#descripcion').val(),"valor":$('#valor').val(),"fecha":$('#fecha').val()},
                success:function(data){

                console.log(data);
                //$('#intid').val(data['msj'][0].id);

                 },
              }); 

             }else{

              $('#alertas').html('Falta Informacion');
              $('#alertas').fadeIn(3000);


             }

             });
              
            

            });

</script>


@endsection