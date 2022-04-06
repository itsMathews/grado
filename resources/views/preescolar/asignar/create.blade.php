@extends ('layouts.admin')
@section ('contenido')

<div class="row">

	<div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">

	<h3>Nuevo Profesor</h3>

	@if(count($errors)>0)
      <div class="alert alert-danger">
      	<ul>
      	  @foreach($errors->all() as $error)	
      	  <li>{{$error}}</li>
      	  @endforeach
        </ul>
	 </div>
	@endif


	{!! Form::open(array('url'=>'preescolar/adicional','method'=>'POST','autocomplete'=>'off')) !!}
    {{Form::token()}}

   <div class="row">

     <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="nombre">fecha</label>
    <input type="date" format=" yyyy-mm-dd" name="fecha" class="form-control" >
    </div>

     </div>

     <div class="col-lg-4 co-md-4 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="nombre">Decripcion</label>
    <input type="text" name="descripcion" class="form-control" placeholder="Nombres">
    </div>
    
     </div>

      <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="nombre">Precio</label>
    <input type="text" name="valor" class="form-control" placeholder="Apellidos">
    </div>
    
     </div>


    

    

   </div>


   

    <div class="form-group">

    <button class="btn btn-primary" type="sumit">Guardar</button>
    <button class="btn btn-danger" type="reset">Cancelar</button>

    </div>


	{!! Form::close() !!}

    </div>

</div>

@endsection