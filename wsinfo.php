<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>MiniSAR</title>

	<link rel="stylesheet" href="SARinfo/css/bootstrap.css" />
	<link href="SARinfo/css/style.css" rel="stylesheet" type="text/css" media="screen" />
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</head>

<body>
<section class="container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<header class="row pt-8 col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-10 col-md-10 col-sm-9 col-xs-9 pt-5 pl-5">
			<p class="text-uppercase display-4" style="color: white;">Laboratorio de Informática</p>
			<p class="display-3" style="color: white;">Módulo de Horas Libres</p>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
			<span class="thumbnail" style="background: #184391; border: none;">
				<a href="index.php"><img src="img/logo.png" alt="logo UDB" /></a>
			</span>
		</div>
	</header>
</section>

<section class="text-center">

<?php
$año = date("Y");
$ciclo = "";

if (date("n") >= 1 && date("n") <= 5) {
	$ciclo = "01";
} elseif (date("n") >= 6 && date("n") <= 10) {
	$ciclo = "02";
} else {
	$ciclo = "03";
}

include("conectar.php");
conectarse();

$Car = isset($_POST["carnet"]) ? trim($_POST["carnet"]) : "";
$sala = isset($_POST["sala"]) ? trim($_POST["sala"]) : "";

if ($Car == "" || $sala == "") {
	echo "<h3>Datos incompletos</h3>";
	echo "<html><head><meta http-equiv=\"Refresh\" content=\"2;url=index.php\"></head></html>";
	exit;
}

$url = "https://admacad.udb.edu.sv/LoginService/api/Login/DatosAlumno/{$Car}";

// Inicializar CURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);

if (curl_errno($ch)) {
	echo 'Error CURL: ' . curl_error($ch);
	curl_close($ch);
	exit;
}

curl_close($ch);

$resultado = json_decode($response);

if ($resultado == null || $resultado == "") {
	echo "<h3>No existe en nuestra base de datos</h3>";
	echo "<html><head><meta http-equiv=\"Refresh\" content=\"3;url=index.php?s=$sala\"></head></html>";
} else {
	?>
	<h1>Registro Encontrado</h1>

	<div class="container-fluid col-lg-12 col-md-12 bg-info text-white">
		<div class="row col-lg-8 col-md-8 col-lg-offset-6 col-md-offset-6 justify-content-center">
			<div class="info col-lg-4 col-md-4">
				<div class="text-left"><h2>Carnet: <?php echo htmlspecialchars($Car); ?></h2></div>
				<br>
				<div class="text-left"><h2>Nombre: <?php echo htmlspecialchars($resultado->nombre ?? ''); ?></h2></div>
				<br>

				<?php
				if (!empty($resultado->estado)) {
					?>
					<div><h2>Estado:</h2></div>
					<div><h3>Inscrito(a) en Ciclo <?php echo $ciclo; ?> - <?php echo $año; ?></h3></div>
					<?php
				}
				?>
			</div>

			<div class="col-lg-8 col-md-8">
				<?php
				if (empty($resultado->foto_b64)) {
					?>
					<img src="imagenes/avatar.png" width="200" height="300" alt="avatar">
					<?php
				} else {
					?>
					<img src="<?php echo 'data:image/png;base64,' . $resultado->foto_b64; ?>" width="200" height="300" alt="foto alumno">
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<br>
	<?php

	if (empty($resultado->estado)) {
		echo "<h1 style='color:red'>ALUMNO INACTIVO</h1>";
		echo "<html><head><meta http-equiv=\"Refresh\" content=\"2;url=index.php?s=$sala\"></head></html>";
		exit;
	}

	if (!empty($resultado->nombre)) {

		$sql3 = "SELECT idreserva
				 FROM reserva
				 WHERE idalumno = '$Car'
				 AND hora_salida IS NULL
				 ORDER BY idreserva DESC
				 LIMIT 1";

		$resReserva = mysqli_query($connect, $sql3);

		if (!$resReserva) {
			die("Error al buscar reserva activa: " . mysqli_error($connect));
		}

		$filaReserva = mysqli_fetch_array($resReserva);
		$idreserva = $filaReserva["idreserva"] ?? null;

		$sql = "SELECT COUNT(*) AS contador
				FROM reserva
				WHERE idalumno = '$Car'
				AND hora_salida IS NULL";

		$resContador = mysqli_query($connect, $sql);

		if (!$resContador) {
			die("Error al contar reservas: " . mysqli_error($connect));
		}

		$filaContador = mysqli_fetch_array($resContador);
		$cicloActual = $ciclo . " " . $año;

		if ($filaContador["contador"] == 0) {

			$insertar = "INSERT INTO reserva (idreserva, idalumno, hora_entra, hora_salida, idsala, ciclo)
						 VALUES (NULL, '$Car', NOW(), NULL, '$sala', '$cicloActual')";

			$Ejecutar = mysqli_query($connect, $insertar);

			if (!$Ejecutar) {
				die("Error al insertar reserva: " . mysqli_error($connect));
			}

			echo "<div class='bg-warning p-2'><h3>Marca entrada: " . date("H:i:s") . " | Sala: " . htmlspecialchars($sala) . "</h3></div>";

		} else {

			$Actualiza = "UPDATE reserva
						  SET hora_salida = NOW()
						  WHERE idreserva = '$idreserva'
						  AND hora_salida IS NULL";

			$Ejecutar = mysqli_query($connect, $Actualiza);

			if (!$Ejecutar) {
				die("Error al actualizar salida: " . mysqli_error($connect));
			}

			echo "<div class='bg-danger text-white p-2'><h3>Marca salida: " . date("H:i:s") . " | Sala: " . htmlspecialchars($sala) . "</h3></div>";
		}

		echo "<html><head><meta http-equiv=\"Refresh\" content=\"2;url=index.php?s=$sala\"></head></html>";
	}
}
?>

</section>

<footer class="col-lg-12 col-md-12 col-sm-12 col-xs-12 justify-content-center">
	<p class="legal justify-content-center">© Copyright 2023 | Universidad Don Bosco | All Rights Reserved.</p>
	<p class="credit justify-content-center">Desarrollo: Carlos Alfaro, Herson Serrano, Edwin Bonilla<br>Diseño: Laura Acosta</p>
</footer>
</body>
</html>