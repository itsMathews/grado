@extends ('layouts.admin')
@section ('contenido')

<div class="row">

  <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">

  <h3>Editar Profesor</h3>

  @if(count($errors)>0)
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)  
          <li>{{$error}}</li>
          @endforeach
        </ul>
   </div>
  @endif


  {!! Form::model($persona,['method'=>'PATCH','route'=>['profesor.update',$persona->id]])!!}
    {{Form::token()}}



   <div class="row">

     <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="nombre">Iden</label>
    <input type="text" name="iden" class="form-control"  value="{{$persona->iden}}" placeholder="Iden">
    </div>

     </div>

     <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="nombre">Nombres</label>
    <input type="text" name="nombres" class="form-control" value="{{$persona->nombres}}" placeholder="Nombres">
    </div>
    
     </div>

      <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="nombre">Apellidos</label>
    <input type="text" name="apellidos" class="form-control" value="{{$persona->apellidos}}" placeholder="Apellidos">
    </div>
    
     </div>


     <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="nombre">Telefono</label>
    <input type="text" name="tel" class="form-control" value="{{$persona->tel}}"placeholder="Telefono">
    </div>
    
     </div>

      <div class="col-lg-4 co-md-4 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="nombre">Direccion</label>
    <input type="text" name="direccion" class="form-control" value="{{$persona->direccion}}" placeholder="Direccion">
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