@extends ('layouts.admin')
@section ('contenido')

<div class="row">

	<div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">

	<h3>Editar Egreso : {{$egreso->id}}</h3>

	@if(count($errors)>0)
      <div class="alert alert-danger">
      	<ul>
      	  @foreach($errors->all() as $error)
      	  <li>{{$error}}</li>
      	  @endforeach
        </ul>
	 </div>
	@endif

    </div>

    </div>


  <div class="row">

  <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">


	{!! Form::model($egreso,['method'=>'PATCH','route'=>['egreso.update',$egreso->id]])!!}
    {{Form::token()}}

    <div class="form-group">
    <label for="nombre">Descripcion</label>
    <input type="text" name="descripcion" class="form-control" value="{{$egreso->descripcion}}" placeholder="Descripcion">
    </div>

    </div>

		<div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

    <div class="form-group">
    <label for="nombre">Profesor</label>
    <input type="text" name="profesor" class="form-control" value="{{$egreso->profesor}}" >
    </div>

    </div>


    <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

    <div class="form-group">
    <label for="nombre">Valor</label>
    <input type="text" name="valor" class="form-control" value="{{$egreso->valor}}" >
    </div>

    </div>


    <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

    <div class="form-group">
    <label for="nombre">fecha</label>
    <input type="date" name="fecha" class="form-control" value="{{$egreso->fecha}}" >
    </div>

    </div>





   </div>

   <div class="form-group">

    <button class="btn btn-primary" type="submit">Guardar</button>
    <button class="btn btn-danger" type="reset">Cancelar</button>

    </div>

	{!! Form::close() !!}




@endsection
