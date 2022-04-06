@extends ('layouts.admin')
@section ('contenido')
@include('preescolar.alumno.reporte')

<div class="row">

  <div class="col-lg-8 co-md-8 col-sm-8 col-xs-12">

    <h3>Listado de Alumnos <a href="alumno/create"><button class="btn btn-success">Nuevo alumno</button></a> <button class="btn btn-danger" data-toggle="modal" data-target="#modalumno">Reporte</button>  </h3>

    @include('preescolar/alumno/search')

  </div>

</div>

 {{ csrf_field() }}

<div class="row">

   <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">

     <div class="table-responsive">

      <table class="table table-striped table-bordered table-condensed table-hover">

          <thead class="bg-yellow-gradient">

           <th>Iden</th>
           <th>Nombres</th>
           <th>Apellidos</th>
           <th>Telefono</th>
           <th>Curso</th>
           <th>Direccion</th>
           <th>Estado</th>
           <th>Opciones</th>

         </thead>
           @foreach ($personaa as $per)

           <tr>


            <td>{{ $per->iden}}</td>
            <td>{{ $per->nombres}}</td>
            <td>{{ $per->apellidos}}</td>
            <td>{{ $per->tel}}</td>
            <td>{{ $per->descripcion}}</td>
            <td>{{ $per->direccion}}</td>

            <td>


             <?php  if($per->estado==0){
                    $estado='Activo';

                }else{

                $estado='Inactivo';
              }?>

              <span id="est{{$per->id}}">{{$estado}}</span>

            </td>

            <td><a href="{{URL::action('PersonaaController@edit',$per->id)}}"><button class="btn btn-info">Editar</button></a> <button class="btn btn-success activar" id="acti{{$per->id}}">Activar</button> <button class="btn btn-danger desactivar" id="desa{{$per->id}}">Desactivar</button></td>




           </tr>
           @endforeach
      </table>

     </div>

     {{ $personaa->render() }}

   </div>

</div>


<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>


<script>
        $(document).ready(function(){


            $('.activar').click( function(e){

             //alert(" activando profesores..");

             var id=($(this).attr('id'));
               id=id.substring(4,id.length);

               //alert(id);

              $.ajax({
               type:'post',
               url:'alumno/activar',
                data:{'_token':$('input[name=_token]').val(),'id':id},
                success:function(data){

                console.log(data);
                $('#est'+id).html('Activo');

              },
              });


            });


            $('.desactivar').click( function(e){

            // alert("desactivando profesores..");

             var id=($(this).attr('id'));
               id=id.substring(4,id.length);

               //alert(id);

              $.ajax({
               type:'post',
               url:'alumno/desactivar',
                data:{'_token':$('input[name=_token]').val(),'id':id},
                success:function(data){

                console.log(data);

                $('#est'+id).html('Inactivo');

              },
              });







            });



          });


</script>


@endsection
