@extends ('layouts.admin')
@section ('contenido')

<div class="row">

	<div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">

	<h3>Enviar Email</h3>

	@if(count($errors)>0)
      <div class="alert alert-danger">
      	<ul>
      	  @foreach($errors->all() as $error)
      	  <li>{{$error}}</li>
      	  @endforeach
        </ul>
	 </div>
	@endif


	{!! Form::open(array('url'=>'preescolar/email/correo','method'=>'POST','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
    {{Form::token()}}

<div class="row">

    <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

        <div class="form-group">
            <label for="nombre">enviar a :</label>
            <input type="email" name="email" class="form-control" placeholder="email">
        </div>

    </div>

    <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

        <div class="form-group">
            <label for="nombre">Asunto :</label>
            <input type="text" name="asunto" class="form-control" placeholder="asunto">
        </div>

    </div>

    <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

        <div class="form-group">
            <label for="nombre">Mensaje :</label>
            <input type="text" name="mensaje" class="form-control" placeholder="Mensaje">
        </div>

    </div>


    <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

        <div class="form-group">
            <label for="nombre">Adjunto :</label>
            <input type="file" name="adjunto" class="form-control" placeholder="escoger archivo">
        </div>

    </div>

        <div class="col-lg-4 co-md-4 col-sm-6 col-xs-12">

        

            <input type="hidden" name="tipo" value="1">

        </div>

</div>




    <div class="form-group">

        <button class="btn btn-primary" type="submit">Enviar</button>
        <button class="btn btn-danger" type="reset">Cancelar</button>

    </div>


	{!! Form::close() !!}

    </div>

</div>

@endsection