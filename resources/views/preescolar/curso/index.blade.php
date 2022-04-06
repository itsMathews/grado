@extends ('layouts.admin')
@section ('contenido')
@include('preescolar.curso.reporte')


<div class="row">

	<div class="col-lg-8 co-md-8 col-sm-8 col-xs-12">

		<h3>Listado de Cursos <a href="curso/create"><button class="btn btn-success">Nuevo Curso</button></a> <button class="btn btn-danger" data-toggle="modal" data-target="#modalcurso">Reporte</button>  </h3>

		@include('preescolar/curso/search')

	</div>

</div>


<div class="row">

   <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">

   	 <div class="table-responsive">

   	 	<table class="table table-striped table-bordered table-condensed table-hover">

                    <thead class="bg-yellow-gradient">

           <th>Id</th>
           <th>Nombre</th>
           <th>Opciones</th>

         </thead>
           @foreach ($curso as $cur)
           <tr>
               <td>{{ $cur->id}}</td>
           	<td>{{ $cur->descripcion}}</td>
           	<td><a href="{{URL::action('CursoController@edit',$cur->id)}}"><button class="btn btn-info">Editar</button></a></td>
           </tr>
           @endforeach
   	 	</table>

   	 </div>

   	 {{ $curso->render() }}

   </div>

</div>


@endsection
