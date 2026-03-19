<?php 
include("conectar.php");
conectarse();

$i=0;
if(isset($_POST['submit'])){

$fecha1 = $_POST["ini"];
$fecha2 = $_POST["fin"];
$i++;

//Sentecias sql -  muestra el total de usuarios conforme a un rango de fecha
$sql = " SELECT  count(idalumno) FROM `reserva` WHERE hora_entra BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59'";
$query=mysqli_query($connect,$sql) or die ("Imposible realizar la sentencia sql");
$result = mysqli_fetch_array($query,MYSQLI_NUM);

$sql2 = " SELECT   FROM `reserva` WHERE hora_entra BETWEEN '2016-07-14 00:00:00' AND '2016-07-14 23:59:59'";
$query2=mysqli_query($connect,$sql) or die ("Imposible realizar la sentencia sql");
$result2 = mysqli_fetch_array($query,MYSQLI_NUM);


}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta  charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Consultas</title>
	<link rel="stylesheet" href="bootstrap.css" />
	<link rel="stylesheet" href="style.css">
</head>
<body class="container-fluid">
	<header>
		<div class="title">
			<h2>Laboratorio de Informática</h2>
			<h4>MÓDULO DE HORAS LIBRES</h4>
		</div>
		<div class="logo">
			<img src="img/logo.png" alt="logo UDB" />
		</div>
	</header>
	<section class="contenedor">
		<div id="form01">
			<img src="img/fondo.jpg" alt="" class="fondo">
			<form class="form-inline" method="post" name="form1">
				<div class="form-group form">
					<h2>CONSULTAR</h2>
					<div class="input-group">
						<label for="ini" class="input-group-addon">De: </label>					
						<input class="form-control" type="date" name="ini">
					</div>
					<div class="input-group">
						<label for="fin" class="input-group-addon">Hasta: </label>					
						<input class="form-control" type="date" name="fin">
					</div>
					<div class="botones">
						<input type="submit" name="submit" value="Consultar" class="boton btn"> 
					</div>
				</div>
			</form>
			<div class="prueba" id="prueba">
				<?php
					if (isset($_POST['submit'])) {
						# code...
						echo "<h2>REGISTRO</h2>";
						echo $fecha1." ".$fecha2;
						echo "result".$result[0];

					};
				?>
			</div>
			
		</div>
	</section><!-- end page -->
</body>
</html>