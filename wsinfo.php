<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>MiniSAR</title>

	<link rel="stylesheet" href="home.css" />
	<style>
		.ws-wrapper{
			width:min(1100px, 92%);
			margin:24px auto;
		}

		.ws-card{
			background:#ffffff;
			border-radius:20px;
			box-shadow:0 12px 30px rgba(0,0,0,.10);
			overflow:hidden;
		}

		.ws-title{
			text-align:center;
			font-family:'Oswald', sans-serif;
			font-size:2.4rem;
			color:#184391;
			padding:22px 20px 10px;
			margin:0;
		}

		.ws-content{
			display:grid;
			grid-template-columns: 1fr 320px;
			gap:0;
			align-items:stretch;
			background:#ffffff;
		}

		.ws-info{
			padding:32px;
			background:linear-gradient(135deg, #1d9bb4, #28a9c1);
			color:#fff;
			display:flex;
			flex-direction:column;
			justify-content:center;
		}

		.ws-info h2{
			font-size:1.8rem;
			margin:0 0 16px;
			font-weight:700;
		}

		.ws-info p{
			font-size:1.25rem;
			margin:0 0 14px;
			line-height:1.5;
			font-weight:600;
		}

		.ws-photo{
			background:#f8fafc;
			display:flex;
			align-items:center;
			justify-content:center;
			padding:20px;
		}

		.ws-photo img{
			width:220px;
			height:300px;
			object-fit:cover;
			border-radius:14px;
			box-shadow:0 8px 20px rgba(0,0,0,.12);
			background:#fff;
		}

		.ws-status{
			text-align:center;
			padding:16px 20px;
			font-size:1.5rem;
			font-weight:700;
			color:#fff;
		}

		.ws-status.entrada{
			background:#f4b000;
			color:#1f2937;
		}

		.ws-status.salida{
			background:#dc3545;
		}

		.ws-status.error{
			background:#dc3545;
		}

		.ws-message{
			background:#ffffff;
			border-radius:18px;
			box-shadow:0 12px 30px rgba(0,0,0,.08);
			padding:34px 24px;
			text-align:center;
			width:min(700px, 92%);
			margin:30px auto;
		}

		.ws-message h2{
			font-family:'Oswald', sans-serif;
			font-size:2.2rem;
			color:#184391;
			margin:0 0 10px;
		}

		.ws-message p{
			font-size:1.2rem;
			color:#4b5563;
			margin:0;
		}

		.ws-message.error h2{
			color:#dc3545;
		}

		@media (max-width: 900px){
			.ws-content{
				grid-template-columns:1fr;
			}

			.ws-photo img{
				width:180px;
				height:250px;
			}
		}
	</style>
</head>
<body>

<header class="home-header">
	<div class="home-header-inner">
		<div class="home-brand">
			<h1>Laboratorio de Informática</h1>
			<p>Módulo de horas libres</p>
		</div>
		<div class="home-logo">
			<a href="index.php">
				<img src="img/logo.png" alt="Logo UDB" />
			</a>
		</div>
	</div>
</header>

<main class="ws-wrapper">
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
	echo '<div class="ws-message error">';
	echo '<h2>Datos incompletos</h2>';
	echo '<p>Debes ingresar un carnet y seleccionar una sala.</p>';
	echo '</div>';
	echo '<meta http-equiv="Refresh" content="2;url=index.php">';
	exit;
}

$url = "https://admacad.udb.edu.sv/LoginService/api/Login/DatosAlumno/{$Car}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);

if (curl_errno($ch)) {
	echo '<div class="ws-message error">';
	echo '<h2>Error de conexión</h2>';
	echo '<p>' . htmlspecialchars(curl_error($ch)) . '</p>';
	echo '</div>';
	curl_close($ch);
	exit;
}

curl_close($ch);

$resultado = json_decode($response);

if ($resultado == null || $resultado == "") {
	echo '<div class="ws-message error">';
	echo '<h2>Usuario no encontrado</h2>';
	echo '<p>No existe en nuestra base de datos.</p>';
	echo '</div>';
	echo '<meta http-equiv="Refresh" content="3;url=index.php?s=' . htmlspecialchars($sala) . '">';
} else {
	?>
	<div class="ws-card">
		<h1 class="ws-title">Registro encontrado</h1>

		<div class="ws-content">
			<div class="ws-info">
				<h2>Carnet: <?php echo htmlspecialchars($Car); ?></h2>
				<p>Nombre: <?php echo htmlspecialchars($resultado->nombre ?? ''); ?></p>

				<?php if (!empty($resultado->estado)) { ?>
					<p>Estado: Inscrito(a) en Ciclo <?php echo $ciclo; ?> - <?php echo $año; ?></p>
				<?php } else { ?>
					<p>Estado: Alumno inactivo</p>
				<?php } ?>
			</div>

			<div class="ws-photo">
				<?php if (empty($resultado->foto_b64)) { ?>
					<img src="imagenes/avatar.png" alt="avatar">
				<?php } else { ?>
					<img src="<?php echo 'data:image/png;base64,' . $resultado->foto_b64; ?>" alt="foto alumno">
				<?php } ?>
			</div>
		</div>

		<?php
		if (empty($resultado->estado)) {
			echo '<div class="ws-status error">Alumno inactivo</div>';
			echo '<meta http-equiv="Refresh" content="2;url=index.php?s=' . htmlspecialchars($sala) . '">';
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

				echo '<div class="ws-status entrada">Marca entrada: ' . date("H:i:s") . ' | Sala: ' . htmlspecialchars($sala) . '</div>';

			} else {

				$Actualiza = "UPDATE reserva
							  SET hora_salida = NOW()
							  WHERE idreserva = '$idreserva'
							  AND hora_salida IS NULL";

				$Ejecutar = mysqli_query($connect, $Actualiza);

				if (!$Ejecutar) {
					die("Error al actualizar salida: " . mysqli_error($connect));
				}

				echo '<div class="ws-status salida">Marca salida: ' . date("H:i:s") . ' | Sala: ' . htmlspecialchars($sala) . '</div>';
			}

			echo '<meta http-equiv="Refresh" content="2;url=index.php?s=' . htmlspecialchars($sala) . '">';
		}
		?>
	</div>
	<?php
}
?>
</main>

<footer class="home-footer">
	<p>© Copyright 2026 | Universidad Don Bosco | All Rights Reserved.</p>
	<p>Desarrollo: Verónica Abrego, Carlos Alfaro</p>
</footer>

</body>
</html>