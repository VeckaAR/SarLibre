<?php 	
	$H = '00';
	$M = '00';
	$S = '00';

	$año=date("Y");

function ObtenerCantHoras()
	{
		global $año;
		$con = new conexion();
		$sql= "SELECT hora_entra, hora_salida FROM `reserva` WHere Year(hora_entra) = $año";
		$res= mysqli_query($con->getConexion(),$sql);

		$horaAsumar = '';
		global $H,$M,$S;		
		
		while($row = mysqli_fetch_assoc($res)){
			$f1 = date_create($row['hora_entra']);
			$f2 = date_create( $row['hora_salida']);

			$horaAsumar = $f1->diff($f2);
			$horaAsumar= $horaAsumar->format('%H:%I:%s');
			sumar($horaAsumar);			
		}

		mysqli_close($con->getConexion());
		echo $H.":".$M .":". $S;	

	}


	function ObtenerCantAlumnos()
	{
		# code...
		global $año;
		$con = new conexion();

		$sql= "SELECT count(DISTINCT idalumno) as alumno FROM `reserva` WHere Year(hora_entra) = $año";
		$res= mysqli_query($con->getConexion(),$sql);

		$row = mysqli_fetch_assoc($res);
		mysqli_close($con->getConexion());
		echo $row['alumno'];

	}

	function ObtenerCantEntradas($carnet, $fecha1, $fecha2)
	{
		# code...
		$con = new conexion();

		$sql= "SELECT count(idalumno) as alumno FROM `reserva` WHERE idalumno = '$carnet' and hora_entra BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59'";
		$res= mysqli_query($con->getConexion(),$sql);

		$row = mysqli_fetch_assoc($res);
		mysqli_close($con->getConexion());
		echo $row['alumno'];
		

	}

	function ObtenerCiclo()
	{
		global $año;
		# code...
		if (date("n")>0 && date("n")<6) {
		# code...
			echo "Ciclo 01 ".$año;
		
			}else if (date("n")>7 && date("n")<13) {
		# code...
			echo "Ciclo 02 ".$año;
			}else echo "Ciclo 03 ".$año;

	}

	function ObtenerHorasxAlumno($carnet, $fecha1, $fecha2)
	{
		$con = new conexion();
		$sql= "SELECT hora_entra, hora_salida FROM `reserva` WHERE idalumno = '$carnet' and hora_entra BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59 '";
		$res= mysqli_query($con->getConexion(),$sql);

		$horaAsumar = '';
		global $H,$M,$S;		
		
		while($row = mysqli_fetch_assoc($res)){
			$f1 = date_create($row['hora_entra']);
			$f2 = date_create( $row['hora_salida']);

			$horaAsumar = $f1->diff($f2);
			$horaAsumar= $horaAsumar->format('%H:%I:%s');
			sumar($horaAsumar);			
		}

		mysqli_close($con->getConexion());
		echo $H.":".$M .":". $S;	

	}

	function ObtenerEntradas($fecha1, $fecha2)
	{
		# code...
		$con = new conexion();

		$sql= "SELECT count(idalumno) as alumno FROM `reserva` WHERE hora_entra BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59'";
		$res= mysqli_query($con->getConexion(),$sql);

		$row = mysqli_fetch_assoc($res);
		mysqli_close($con->getConexion());
		echo $row['alumno'];
		

	}

	function ObtenerHoras($fecha1, $fecha2)
	{
		$con = new conexion();
		$sql= "SELECT hora_entra, hora_salida FROM `reserva` WHERE  hora_entra BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59 '";
		$res= mysqli_query($con->getConexion(),$sql);

		$horaAsumar = '';
		global $H,$M,$S;		
		
		while($row = mysqli_fetch_assoc($res)){
			$f1 = date_create($row['hora_entra']);
			$f2 = date_create( $row['hora_salida']);

			$horaAsumar = $f1->diff($f2);
			$horaAsumar= $horaAsumar->format('%H:%I:%s');
			sumar($horaAsumar);			
		}

		mysqli_close($con->getConexion());
		echo $H.":".$M .":". $S;	

	}

	function sumar($hora2)
	{
		global $H,$M,$S;		
		list($h,$m,$s) = explode(':', $hora2);
		//segundos
		$S = $S+$s;
		if ($S >= 60) {
			# code...
			$S = $S-60;
			$M = $M+1;
		}
		//minutos
		$M = $M+$m;	
		if ($M >= 60) {
			# code...
			$M = $M-60;
			$H = $H+1;
		}
		//hora
		$H = $H+$h;	
	}

	



 ?>