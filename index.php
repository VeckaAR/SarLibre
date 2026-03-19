<?php
include("conectar.php");
conectarse();
$param_sala=@$_GET["s"];
if(!isset($param_sala))
	$param_sala=0;

$salas = array();
$query_salas = mysqli_query($connect, "SELECT idsala FROM salas ORDER BY idsala ASC");
while ($sala = mysqli_fetch_assoc($query_salas)) {
	array_push($salas, array($sala["idsala"], 0, false, 0));
}

$ocupados = array();
$query_reservas = mysqli_query($connect, "SELECT count(*) AS cantidad, R.idsala, S.capacidad FROM reserva R INNER JOIN salas S on S.idsala = R.idsala WHERE R.hora_salida = 0 OR R.hora_salida IS NULL GROUP BY R.idsala, S.capacidad");
while ($ocupado = mysqli_fetch_assoc($query_reservas)) {
	array_push($ocupados, array($ocupado["idsala"], $ocupado["cantidad"], $ocupado["capacidad"]));
}

foreach ($ocupados as $ocupado) {
	$key = array_search(array($ocupado[0], 0, false, 0), $salas);
	if ($key !== false) {
		$salas[$key][1] = $ocupado[1];
		$salas[$key][3] = $ocupado[2];
		if ($ocupado[1] >= $ocupado[2]) {
			$salas[$key][2] = true;
		}
	}
}

$query_capacidades = mysqli_query($connect, "SELECT capacidad FROM salas ORDER BY idsala ASC");
$i = 0;
while ($capacidad = mysqli_fetch_assoc($query_capacidades)) {
	$salas[$i][3] = $capacidad["capacidad"];
	$i = $i+1;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Laboratorio de Informática | Módulo de horas libres</title>
	<link rel="stylesheet" href="bootstrap.css" />
	<link rel="stylesheet" href="home.css" />
	<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
</head>
<body onload="document.form1.carnet.focus()">
	<header class="home-header">
		<div class="home-header-inner">
			<div class="">
				<h1>Laboratorio de Informática</h1>
				<p>Módulo de horas libres</p>
			</div>
			<div class="home-logo">
				<img src="img/logo.png" alt="Logo UDB" />
			</div>
		</div>
	</header>

	<main class="home-main">
		<section class="hero-card">
			<div class="hero-overlay"></div>

			<div class="hero-left">
				<form action="wsinfo.php" method="post" name="form1" id="form1" class="access-card">
					<h2>Bienvenido</h2>
					<p>Realiza tu reserva de forma rápida y segura.</p>

					<div class="field">
						<label for="idcarnet">Carnet</label>
						<input type="text" id="idcarnet" name="carnet" required autofocus>
					</div>

					<div class="field">
						<label for="salaSelect">Sala</label>
						<select name="sala" id="salaSelect">
							<?php foreach($salas as $sala): ?>
								<option
									data-max="<?=$sala[3]?>"
									data-cant="<?=$sala[1]?>"
									<?=$param_sala == $sala[0] ? "selected" : ""?>
									value="<?=$sala[0]?>">
									Sala <?=$sala[0]?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="actions">
						<a class="home-btn secondary" href="SARinfo/menuInfo.php">Consultar</a>
						<a class="home-btn secondary" href="cortehoras.php">Realizar corte</a>
						<input type="submit" value="Reservar" class="home-btn primary">
					</div>
				</form>
			</div>

			<div class="hero-right"></div>
		</section>

		<section class="status-section">
			<div class="status-title">Estudiantes en horas libres</div>
			<p class="status-subtitle">Disponibilidad actual por laboratorio</p>

			<div class="rooms-grid">
				<?php foreach($salas as $sala): ?>
					<div class="room-box <?=$sala[2] == true ? "full" : ""?>">
						<div class="room-name">Sala <?=$sala[0]?></div>
						<div class="room-count"><?=$sala[1]?></div>
						<div class="room-capacity">Capacidad: <?=$sala[3]?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</main>

	<footer class="home-footer">
        <p>© Copyright 2026 | Universidad Don Bosco | All Rights Reserved.</p>
        <p>Desarrollo: Verónica Abrego</p>
    </footer>

<script>
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
</body>
</html>
