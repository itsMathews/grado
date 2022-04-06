@extends ('layouts.admin')
@section ('contenido')
<?php $aux = '2';?>
@include('preescolar.reportegeneral.reporte')



<div class="row">

	<div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">


    <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">
   <label for="descripcion">Alumno</label>
  <select style="width:100%" id="alufil" class="form-control">

           <option value="0">Seleccione</option>

           @foreach ($alumno as $alu)

           <option value="{{$alu->id}}">{{$alu->nombres.' '.$alu->apellidos}}</option>


           @endforeach

           </select>

 </div>

 <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">Fecha Ini</label>
    <input type="date" name="feifil" id="feifil" class="form-control"  value="" placeholder="valor">
    </div>

   </div>


   <div class="col-lg-2 co-md-2 col-sm-6 col-xs-12">

      <div class="form-group">
    <label for="descripcion">Fecha Fin</label>
    <input type="date" name="feffil" id="feffil" class="form-control"  value="" placeholder="valor">
    </div>

   </div>

    <button class="btn btn-success btn-activite" id="btfil" style="top: 23.5px;position: relative;">Filtrar</button>
    <!--
      <button class="btn btn-danger" data-toggle="modal" data-target="#modalrepgen" style="top: 23.5px;position: relative;">Reporte</button>
    -->
    <button class="btn btn-danger" style="top: 23.5px;position: relative;" onclick="abrirModal('#modalrepgen')">Reporte</button>

	</div>

</div>


<br>



<div class="row">

   <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">

     <div id="alertas" class="alert alert-info"></div>

     {{ csrf_field() }}

   	 <div class="table-responsive">

   	 	<table id="infotable"class="table table-striped table-bordered table-condensed table-hover">


                    <thead class="bg-yellow-gradient">
                    <th>Id</th>
                    <th>Iden</th>
                    <th>Nombre</th>
                    <th>Alimentacion</th>
                    <th>Adicional</th>
                    <th>Ingreso</th>
                    <th>Debe</th>
           
                </thead>
                
                <tr>
                    
                </tr>


   	 	</table>

   	 </div>





   </div>

</div>





<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>


<script>
  function abrirModal(val){
              $(val).modal("show")
              let a =$("#alufil").val()
              let b =$("#feifil").val()
              let c =$("#feffil").val()

              let aux = a + '/' + b + '/' + c
              
              $.ajax(
                {
                  
                    url: './reporte.php?aux='+aux,
                }
               )

            }

        $(document).ready(function(){








          //alert($('input[name=_token]').val());
            $('#alertas').hide();

        //$("#modaladicional").modal('show');

            function cambiarestado(id,estado){

             $.ajax({
               type:'post',
               url:'adicional/cambiar',
                data:{'_token':$('input[name=_token]').val(),'id':id,'nestado':estado},
                success:function(data){

                if(estado==0){

                  $('#btna'+id).prop('disabled',true);
                  $('#btnd'+id).prop('disabled',false);

                }else{

                  $('#btna'+id).prop('disabled',false);
                  $('#btnd'+id).prop('disabled',true);



                }




                 $('#estado'+id).html(data.msj);
                 $('#alertas').fadeIn();
                  $('#alertas').fadeOut(4000);

                },


              });


            }




             //data:{'_token':$('input[name=_token]').val(),'id':id,'nestado':estado},

            $('#btfil').click( function(e){

            // alert("filtrando...");
            //$('#alufil').val()
            //$('#feifil').val()
            //$('#feffil').val()


            document.getElementById("frarep").src = "http://localhost:8000/preescolar/reportegeneral/reporte/"+$('#alufil').val()+"-*-"+$('#feifil').val()+"-*-"+$('#feffil').val();

              $.ajax({
               type:'post',
               url:'reportegeneral/filtro',
                data:{'_token':$('input[name=_token]').val(),"alumno":$('#alufil').val(),"feifil":$('#feifil').val(),"feffil":$('#feffil').val()},
                success:function(data){

                   lin='';

                    lin+='<thead class="bg-yellow-gradient">'+
                    '<th>Id</th>'+
                    '<th>Iden</th>'+
                    '<th>Nombre</th>'+
                    '<th>Alimentacion</th>'+
                    '<th>Adicional</th>'+
                    '<th>Ingreso</th>'+
                    '<th>Debe</th>'+
                    '</thead>';

                    $("#infotable").html('');

                  if(data['msj'].length>0){
                for(i=0;i<data['msj'].length;i++){



                 lin+='<tr>'+
                 '<td>'+data['msj'][i].alumno+'</td>'+
                 '<td>'+data['msj'][i].iden+'</td>'+
                 '<td>'+data['msj'][i].nombre+'</td>'+
                 '<td>'+data['msj'][i].alimentacion+'</td>'+
                 '<td>'+data['msj'][i].adicional+'</td>'+
                 '<td>'+data['msj'][i].ingreso+'</td>'+
                 '<td>'+data['msj'][i].debe+'</td>'+
                 '</tr>';
                }
              }


                $("#infotable").append(lin);


                 console.log(data);


                },


              });

            });

            });
            

</script>


@endsection
