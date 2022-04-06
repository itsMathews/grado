@extends ('layouts.admin')
@section ('contenido')

<div class="row">

  <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">

  <h3>Editar Adicional</h3>

  @if(count($errors)>0)
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)  
          <li>{{$error}}</li>
          @endforeach
        </ul>
   </div>
  @endif


  {!! Form::model($adicional,['method'=>'PATCH','route'=>['adicional.update',$adicional->id]])!!}
    {{Form::token()}}

   <input type="checkbox" class="published" data-id="1">

   


   <div class="row">

     <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="nombre">Fecha</label>
    <input type="date" name="fecha" class="form-control"  value="{{$adicional->fecha}}" placeholder="Iden">
    </div>

     </div>

     <div class="col-lg-4 co-md-4 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="nombre">Descripcion</label>
    <input type="text" name="descripcion" class="form-control" value="{{$adicional->descripcion}}" placeholder="Nombres">
    </div>
    
     </div>

      <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="nombre">Precio</label>
    <input type="text" name="valor" class="form-control" value="{{$adicional->valor}}" placeholder="Apellidos">
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

 <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>


<script>
        $(document).ready(function(){

         
            });

</script>


@endsection