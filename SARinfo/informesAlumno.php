<?php 
	include_once 'view/header.php';
	include_once 'view/registrosHoras.php';

	if (isset($_POST['carnet'])) {
		# code...
		include_once 'view/resultados.php';
	}else{
		echo "<div class='jumbotron jumbotron-fluid'>
      				<div class='container'>
        				<h1 class='display-3'>Informes Hora Libre</h1>
        				<p class='lead'>Ingrese el numero de carnet y rango de fechas para ver el registro de alumnos</p>
      				</div>
    			</div>";
	}
	include_once 'view/footer.php';
 ?>