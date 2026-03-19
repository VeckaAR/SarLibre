<?php
include("conectar.php");
conectarse();
$param_sala=@$_GET["s"];
if(!isset($param_sala))
	$param_sala=0;

$salas = array();
$query_salas = mysqli_query($connect, "SELECT idsala FROM salas ORDER BY idsala ASC");
while ($sala = mysqli_fetch_assoc($query_salas)) {
	// la primera es el id, la segunda es la cantidad actual, la tercera es si esta lleno o no
	array_push($salas, array($sala["idsala"], 0, false, 0));
}

$ocupados = array();
$query_reservas = mysqli_query($connect, "SELECT count( * ) AS cantidad, R.idsala, S.capacidad FROM reserva R INNER JOIN salas S on S.idsala = R.idsala WHERE R.hora_salida = 0 OR R.hora_salida IS NULL GROUP BY R.idsala, S.capacidad");
while ($ocupado = mysqli_fetch_assoc($query_reservas)) {
	array_push($ocupados, array($ocupado["idsala"], $ocupado["cantidad"], $ocupado["capacidad"]));
}

foreach ($ocupados as $ocupado) {
	$key = array_search(array($ocupado[0], 0, false, 0), $salas);
	$salas[$key][1] = $ocupado[1];
	$salas[$key][3] = $ocupado[2];
	if ($ocupado[1] >= $ocupado[2])
		$salas[$key][2] = true;
}

$query_capacidades = mysqli_query($connect, "SELECT capacidad FROM salas ORDER BY idsala ASC");
$i = 0;
while ($capacidad = mysqli_fetch_assoc($query_capacidades)) {
	$salas[$i][3] = $capacidad["capacidad"];
	$i = $i+1;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Document</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>MiniSAR</title>
	<link rel="stylesheet" href="bootstrap.css" />
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
	<script   src="https://code.jquery.com/jquery-2.2.4.js"   integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="   crossorigin="anonymous"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$(document).on("click",".aConsultar",function(e){
			console.log("hola");
			window.location.href = "matenimiento.php"+"?carnet="+$("#idcarnet").val()+""; //Envío carnet
		});
	})
	</script>
	<?php
/*foreach ($variable as $key => $value) {
	# code...
}*/

?>
</head>
<body onload="form1.carnet.focus()">
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
			<form class="form-inline" action="wsinfo.php" method="post" name="form1" id="form1">
				<div class="form">
					<h2>BIENVENIDO</h2>
					<div class="">
						<label for="Carnet" class="lbcarnet lb">Carnet: </label>					
						<input class="ipcarnet"type="text" id="idcarnet" name="carnet" required autofocus>
					</div>
					<div class="select">
						<label for="Sala" class="lb" >Sala:&nbsp;&nbsp;&nbsp; </label>
						<select name="sala" id="salaSelect">
							<?php foreach($salas as $sala): ?>
								<option data-max="<?=$sala[3]?>" data-cant=<?=$sala[1]?> <?=$param_sala == $sala[0] ? "selected" : ""?> value="<?=$sala[0]?>">
									<?=$sala[0]?>
								</option>	
							<?php endforeach; ?>
						</select>
					</div>
					<div class="botones">
						<a class="boton btn" href="SARinfo/menuInfo.php">Consultar</a>
						<a href="cortehoras.php" class="boton btn" >Realizar corte</a>
						<input type="submit" value="Reservar" class="btn btncorte"> 
					</div>
				</div>

			</form>
			<p> 
				<form id="frm" action="consulta.php">
					<!-- class="btn btn-warning" href="consulta.php"></a> -->
					<input type="hidden" name="txtCarnet" value="">
				</form>
			</p>
		</div>

		<span class="Estilo7">ESTUDIANTES EN HORAS LIBRES </span>
		<div id="wrapper" class="wrapper">
			<div id="page">
				<table class="tbstilo">
					<tr>
						<?php foreach($salas as $sala): ?>
							<td><div align="center">Sala <?=$sala[0]?></div></td>	
						<?php endforeach; ?>
		
					</tr>
					<tr class="trborder">
						<?php foreach($salas as $sala): ?>
							<td class="<?=$sala[2] == true ? "bg-red" : ""?>">
								<div align="center"><?=$sala[1]?></div>
							</td>	
						<?php endforeach; ?>
					</tr>
				</table>
			</div>
		</div>
	</section><!-- end page -->
	<footer class="col-lg-12 col-md-12 col-sm-12 col-xs-12 justify-content-center">
        <p class="legal justify-content-center">© Copyright 2026 | Universidad Don Bosco | All Rights Reserved.</p>
        <p class="credit">Desarrollo: Verónica Abrego</p>
    </footer>

</body>
<script language="JavaScript">
document.form1.carnet.focus();

let form = document.querySelector("#form1");
form.addEventListener("submit", (e) => {
	let salaSelect = document.querySelector("#salaSelect");
	let max = salaSelect[salaSelect.selectedIndex].getAttribute("data-max");
	let cant = salaSelect[salaSelect.selectedIndex].getAttribute("data-cant");
	// if (cant >= max) {
	// 	alert("No se puede reservar porque esta sala ya alcanzó su máxima cantidad");
	// 	e.preventDefault();
	// }
});

</script>
</html>
