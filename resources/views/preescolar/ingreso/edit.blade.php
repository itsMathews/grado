@extends ('layouts.admin')
@section ('contenido')

<div class="row">

	<div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">

	<h3>Editar Ingreso : {{$ingreso->id}}</h3>

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

  <div class="col-lg-4 co-md-4 col-sm-6 col-xs-12">


	{!! Form::model($ingreso,['method'=>'PATCH','route'=>['ingreso.update',$ingreso->id]])!!}
    {{Form::token()}}

    <div class="form-group">
    <label for="nombre">Descripcion</label>
    <input type="text" name="descripcion" class="form-control" value="{{$ingreso->descripcion}}" placeholder="Descripcion">
    </div>

    </div>

		<div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

    <div class="form-group">
    <label for="nombre">Alumno</label>
    <input type="text" name="alumno" class="form-control" value="{{$ingreso->alumno}}" >
    </div>

    </div>


    <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

    <div class="form-group">
    <label for="nombre">Valor</label>
    <input type="text" name="valor" class="form-control" value="{{$ingreso->valor}}" >
    </div>

    </div>


    <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

    <div class="form-group">
    <label for="nombre">fecha</label>
    <input type="date" name="fecha" class="form-control" value="{{$ingreso->fecha}}" >
    </div>

    </div>





   </div>

   <div class="form-group">

    <button class="btn btn-primary" type="submit">Guardar</button>
    <button class="btn btn-danger" type="reset">Cancelar</button>

    </div>

	{!! Form::close() !!}




@endsection
