@extends ('layouts.admin')
@section ('contenido')

<div class="row">

	<div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">

	<h3>Editar Curso : {{$curso->descripcion}}</h3>

	@if(count($errors)>0)
      <div class="alert alert-danger">
      	<ul>
      	  @foreach($errors->all() as $error)	
      	  <li>{{$error}}</li>
      	  @endforeach
        </ul>
	 </div>
	@endif


	{!! Form::model($curso,['method'=>'PATCH','route'=>['curso.update',$curso->id]])!!}
    {{Form::token()}}

    <div class="form-group">
    <label for="nombre">nombre</label>
    <input type="text" name="descripcion" class="form-control" value="{{$curso->descripcion}}" placeholder="Descripcion">
    </div>

    <div class="form-group">

    <button class="btn btn-primary" type="sumit">Guardar</button>
    <button class="btn btn-danger" type="reset">Cancelar</button>

    </div>


	{!! Form::close() !!}

    </div>

</div>

@endsection