{!! Form::open(array('url'=>'preescolar/compras','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}

<div class="form-group">

  <div class="input-group">

  	<input type="text" class="form-control" name="search" placeholder="Buscar..." vakue="{{ $search}}">

  	<span class="input-group-btn">
  		
  		<button type="submit" class="btn btn-primary">Buscar</button> 
  	</span>

  </div>


</div>

{{ Form::close()}}