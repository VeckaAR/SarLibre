<?php 
extract($_POST);
	
  include('controller/controllerReserva.php');
  include('controller/controller.php');
 ?>
 <div class="container">
<form action="informesGeneral.php" method="post" class=" col-md-12 form-inline mt-4 justify-content-center"  >	
	
	<label for="example-datetime-local-input" class="mr-sm-2">Desde:</label>
	<input class="form-control mb-2 mr-sm-2 mb-sm-0" type="date" value="YYYY-MM-DD" id="example-datetime-local-input" name="fecha1" required="true">
	<label for="example-datetime-local-input" class="mr-sm-2">Hasta:</label>
	<input class="form-control mb-2 mr-sm-2 mb-sm-0" type="date" value="YYYY-MM-DD" id="example-datetime-local-input" name="fecha2" required="true">
	<input type="submit" class="btn btn-primary col-md-1" name="busqueda" value="Enviar">		
</form>
</div>



<?php 
	if (isset($busqueda)) {
		# code... 
?> 
<div class="row mt-4 p-4 bg-info justify-content-center text-center">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
  <h3 class="text-white">Informe Hora libre</h3>

   <label for="" class="">Entradas:</label>
   <h4 class=" text-white"><?php ObtenerEntradas($fecha1, $fecha2); ?></h4>
   <label for="" class="">N Horas:</label>
   <h4 class="text-white"><?php ObtenerHoras($fecha1, $fecha2); ?></h4>

 </div>
</div>
<br><br>
<div class="col-lg-12"></div>


<div class="col-md-1"></div>
<div class="col-md-10">	

<?php
		mostrarInfoGeneral($fecha1, $fecha2);
	}else{

		echo "<div class='jumbotron jumbotron-fluid mt-5'>
      				<div class='container'>
        				<h1 class='display-3'>Busqueda de Registro</h1>
        				<p class='lead'>Ingrese rango de fecha para buscar los registros de horas libre</p>
      				</div>
    			</div>";
	}
	
 ?>

</div>
<div class="col-md-1"></div>