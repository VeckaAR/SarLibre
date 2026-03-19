<?php 
  extract($_POST);
  include('WsManagement.php');
  
  $ws = new WsManagement();
  $tmp = $ws->wsALumno();
  header('Content-Type: text/html; charset=ISO-8859-1');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Informes</title>
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<script  src="https://code.jquery.com/jquery-2.2.4.min.js"  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="  crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

</head>
<body>
	<form action="informes.php?op=alumnos" method="post" class="form-inline mt-2 justify-content-center"  >	
		<?php 

		if (isset($_GET['op']) == "alumnos") {
		# code...
			?>
			
				<label for="inlineFormInput" class="mr-sm-2">Carnet:</label>
			
				<input class="form-control mb-2 mr-sm-2 mb-sm-0" type="text" name="carnet" placeholder="Carnet" id="carnet" required="true">						

			<?php
		}
		?>

			<label for="example-datetime-local-input" class="mr-sm-2">Desde:</label>
			<input class="form-control mb-2 mr-sm-2 mb-sm-0" type="date" value="2016-08-19" id="example-datetime-local-input" name="fecha1">
			<label for="example-datetime-local-input" class="mr-sm-2">Hasta:</label>
			<input class="form-control mb-2 mr-sm-2 mb-sm-0" type="date" value="2016-08-19" id="example-datetime-local-input" name="fecha2">
			<input type="submit" class="btn btn-primary" name="busqueda" value="Enviar">		
	</form>
	<div class="row mt-4 p-4 bg-info justify-content-center">
	<?php 


		if (isset($_GET['op']) == "alumnos") {
		# code...
	?>
			
				<div class="col-sm-12 col-md-2 col-xs-12">
    				<span class="thumbnail mx-auto">
                <?php if ($tmp->getImg()==""): ?>
                  <img src="img/avatar.png">
                <?php else: ?>
                  <img src='<?php echo "data:image/png;base64,".$tmp->getImg(); ?>' alt="...">  
                <?php endif ?>
      					
    				</span>
  				</div>
  				
  				<div class="col-sm-6 col-md-3 col-xs-12 row justify-content-end">
  					<h3 class="text-white col-md-12 col-sm-12">Alumno</h3>
  					<label for="" class="col-md-3 col-sm-3 ">Carnet: </label>
    				<h6 class="col-sm-9 col-md-9 col-xs-12"><?php echo $tmp->getCarnet();; ?></h6>
    				<label for="" class="col-md-3 col-sm-3">Nombre: </label>
    				<h6 class="col-sm-9 col-md-9 col-xs-12"><?php echo $tmp->getNombre(); ?></h6>
    				<label for="" class="col-md-3 col-sm-3">Apellidos: </label>
    				<h6 class="col-sm-9 col-md-9 col-xs-12"><?php echo $tmp->getApellidos(); ?></h6>
  				</div>

  				<div class="col-sm-6 col-md-3 row col-xs-12 justify-content-end">
  					<h3 class="text-white col-md-12 col-sm-12">Horas Libre</h3>
    				<h6 class="col-sm-12 text-white"> <?php if (isset($_POST['fecha1']) ): ?>
              
            <?php endif ?></h6>
  					<label for="" class="col-md-3 col-sm-3">Entradas:</label>
    				<h5 class="col-sm-9 text-white">10</h5>
    				<label for="" class="col-md-3 col-sm-3">N Horas:</label>
    				<h5 class="col-sm-9 text-white">12:00</h5>
    				
  				</div>		

			<?php
		} else{
		?>
			<div class="col-sm-6 col-md-3 row ">
  					<h3 class="text-white col-md-12">Horas Libre</h3>
    				<h6 class="col-sm-12 text-white"> 2011-08-19--2011-09-19</h6>
  					<label for="" class="col-md-3">Entradas:</label>
    				<h5 class="col-sm-9 text-white">10</h5>
    				<label for="">N° Horas:</label>
    				<h5 class="col-sm-9 text-white">12:00</h5>
    				
  				</div>
		<?php
			}
		 ?>

	</div>
  
  

	<div class="table p-4">		
    <?php 
        include('controllerReserva.php');        
        mostrarPorAlumno($carnet);      
    ?>

<script>
  $(document).ready(function(){
    $('#demo').DataTable();
});
</script>		

	</div>
	
</body>
</html>

