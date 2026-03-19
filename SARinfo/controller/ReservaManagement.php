<?php 	
	/**
	* 
	*/

	include('conexion.php');
	include('model/Reserva.php');
	class ReservaManagement 
	{
		
		
		function __construct()
		{
			# code...

		}
		
		public function mostrarAlumno($id, $fecha1, $fecha2)
			{
				# code...
				error_reporting(0);
				$con = new conexion();

				$sql = "SELECT * FROM `reserva` where idalumno = '$id' and hora_entra BETWEEN '$fecha1 00:00:00' AND '$fecha2 19:16:27 '";
				$res= mysqli_query($con->getConexion(),$sql);


				
				while ($row = mysqli_fetch_assoc($res)) {
					# code...
					$tmp= new Reserva($row['idreserva'],$row['idalumno'],$row['hora_entra'],$row['hora_salida'],$row['idsala'],$row['ciclo']);

					$list[]=$tmp;

				}

				mysqli_close($con->getConexion());
				return $list;



			}

		public function mostrarInforme($fecha1, $fecha2)
			{
				# code...
				error_reporting(0);
				$con = new conexion();

				$sql = "SELECT * FROM `reserva` where hora_entra BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59 '";
				$res= mysqli_query($con->getConexion(),$sql);


				
				while ($row = mysqli_fetch_assoc($res)) {
					# code...
					$tmp= new Reserva($row['idreserva'],$row['idalumno'],$row['hora_entra'],$row['hora_salida'],$row['idsala'],$row['ciclo']);

					$list[]=$tmp;

				}
				mysqli_close($con->getConexion());
				return $list;

			}

		
	}

 ?>