<html>
<head>
	<title>Laboratorio de Informática</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="style.css">
</head>
<body class="info">
	<?php
	header('Content-Type: text/html; charset=ISO-8859-1');//Para que acepte caracteres especiales
	include("nusoap/lib/nusoap.php");
	include("conectar.php");
	conectarse();
	$Car = $_POST["carnet"];
	$sala = $_POST["sala"];
	//echo $sala;
	$Direccion = "http://admacad.udb.edu.sv/Servicios/datosalumno.asmx?wsdl"; //Asigno la direcci?n del Web Service
	//Instancio el objeto para consumir el webservice
	//$Cliente = new nusoap_client($Direccion,true);
	$Cliente = new nusoap_client($Direccion,'wsdl');
	//A?adimos una peque?a validaci?n por si ocurreo alg?n error al instanciar el cliente
	$Error = $Cliente->getError();
	if($Error)
	{
		echo "Error en constructor".$Error;
	}
	//Con las siguientes l?neas puedo mostrar datos de cualquier estudiante, aunque ya no est? inscrito
	/*$astrid = substr($Car,2,2);
	
	if($astrid>70)
	{
		$year = "19".$astrid;
		}
		else
		{
			$year = "20".$astrid;
		}*/
	//echo $astrid;
	//Par?metros que ser?n pasados hacia el m?todo
		$Parametros = array('carnet'=> $Car, 'ciclo'=> '02', 'anio'=> '2016','clave'=> 'FvT43HOo056==423gtsWGE@&&');
		$Resultado = $Cliente->call('MostrarDatos',$Parametros);

//	echo "<pre>";
//		print_r($Parametros);
//	echo "</pre>";
	//probando:
	//var_dump($Resultado)."</br>";
	//echo $Resultado['ListarResult']['string'][2];
	//probando:
/*	$Columnas = ceil(count($Resultado,1)/count($Resultado,0))-1;
	//var_dump($Resultado)."</br>"; //Sirve para saber qu? contiene la variable $Resultado

	$j=0;
	for($i = 0; $i < ($Columnas-1); $i++)
	{
		$j++;
		if($j==5)
		{
			echo "</br>";
			$j=1;
			}
	echo $Resultado['MostrarDatosResult']['string'][$i]."  ";
	}
*/

	if($Cliente->fault)
	{
		echo "Error!";
		print_r($Resultado);
	}
	else
	{
		$Error = $Cliente->getError();
		if($Error)
		{
			echo "Error". $Cliente->faultstring;
		}

		else{
			if($Resultado["MostrarDatosResult"]["diffgram"] == null || $Resultado["MostrarDatosResult"]["diffgram"] == "")
			{
				echo "<h3> No existe en nuestra base de datos </h3>";
				echo "<html><head><meta http-equiv=\"Refresh\" content=\"3;url=index.php?s=$sala\"></head></html>";
			}
			else{
				echo "<h3> Registro Encontrado </h3>";
			//echo "Resultado";
		//echo "resutado inicial <pre>";
//		print_r($Resultado["MostrarDatosResult"]["diffgram"]);
//		echo "</pre>";


		//echo "<pre>";
//		print_r($Resultado["MostrarDatosResult"]["diffgram"]["DocumentElement"]["Table"]);
//		echo "</pre>";
				$objJson = (object)$Resultado["MostrarDatosResult"]["diffgram"]["DocumentElement"]["Table"];

				echo "
				Carnet:  ".$objJson->carnet."
				<br>Nombre:  ".$objJson->Nombre."
				<br>Apellido:  ".$objJson->Apellido1." ".$objJson->Apellido2."
				<br>Estado:  Inscrito(a) en Ciclo 02 - 2016
				</div>
				<pre>";
			//print_r($objJson);
				echo "</pre>";

		//echo "<pre>";
//		print_r($Resultado["MostrarDatosResult"]["diffgram"]["DocumentElement"]["Table"]["foto"]);
//		echo "</pre>";
		//VALIDAMOS LOS CARNET SIN FOTO
				if(@$Resultado["MostrarDatosResult"]["diffgram"]["DocumentElement"]["Table"]["foto"]=="")
				{
					echo "<img src=imagenes/avatar.png width=200 height=300>";
					echo "<html><head><meta http-equiv=\"Refresh\" content=\"2;url=index.php?s=$sala\"></head></html>";

				}	
				else
				{
					echo "<img src='data:image/png;base64,".$Resultado["MostrarDatosResult"]["diffgram"]["DocumentElement"]["Table"]["foto"]."' width=200 height=300>";
				}
				if($Resultado["MostrarDatosResult"]["diffgram"]["DocumentElement"]["Table"]["carnet"] != ""){

			//Devo enviar los par?mtros recibidos por parte del WS:
					$carnet = $objJson->carnet;
			//echo $carnet;
			//echo "<br><a href=reservar.php?carnet=$Car&sala=$sala>Ir</a>";
			//Inserci?n de registros	

			//Obeteniendo idreserva

					$sql3 = "select idreserva from reserva where idalumno = '".$carnet."' AND hora_salida IS NULL order by idreserva desc limit 0,1";
			//echo $sql3; Esto imprime la consulta mysql
					$q = mysqli_query($connect,$sql3);
					$q = mysqli_fetch_array($q);
					$idreserva = $q["idreserva"];
			//echo "RESERVA".$idreserva;
            //echo "<br>ENTRADA:       ".date("H:i:s")."    EN LA SALA ".$sala;
			//echo "LA QUERY ES: ".$sql2; Probamos la salida
					$query=mysqli_query($connect,$sql3) or die ("Imposible realizar la sentencia sql");


					$sql = "SELECT COUNT(*) contador FROM reserva WHERE idalumno = '".$objJson->carnet."' AND hora_salida is null ";
			//echo $sql;
					$q = mysqli_query($connect,$sql);
					$q = mysqli_fetch_array($q);
			//echo "<br> CONTADOR ES: ". $q["contador"];
					if($q["contador"] == 0){
				//echo "ingresar";
				// codigo para ingresar
				//echo $Car;
						$insertar = "INSERT INTO reserva (idreserva,idalumno, hora_entra, hora_salida, idsala, ciclo) VALUES (NULL, '$Car', now(), NULL, $sala, '02 2016');";
				//echo "CONSULTAAAAAAA ".$insertar;
						$Ejecutar = mysqli_query($connect,$insertar);
						$Ejecutar = @mysqli_fetch_row($Ejecutar);
						echo "<br><h3>Marca entrada:     ".date("H:i:s")."     Sala:     ".$sala."</h3>";
						echo "<html><head><meta http-equiv=\"Refresh\" content=\"2;url=index.php?s=$sala\"></head></html>";
				//exit();
					}else{
				//echo "actualizar";
				// codigo para actualizar
			$Actualiza = "UPDATE reserva SET hora_salida = now() WHERE idreserva = $idreserva  and hora_salida is null"; //Actualiza la hora
			$Ejecutar = mysqli_query($connect,$Actualiza);
			$Ejecutar = @mysqli_fetch_row($Ejecutar);
			echo "<br><h3>Marca Salida:       ".date("H:i:s")."    EN LA SALA ".$sala."</h3>";
		}
		echo "<html><head><meta http-equiv=\"Refresh\" content=\"2;url=index.php?s=$sala\"></head></html>";	          
	}
}
}

}

?>
</body>
</html>