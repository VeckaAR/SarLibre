
<?php

	include("nusoap/lib/nusoap.php");
	include("conectar.php");
    conectarse();
	$Car = $_POST["carnet"];
	$sala = $_POST["sala"];
	
	$Direccion = "http://admacad.udb.edu.sv/Servicios/datosalumno.asmx?wsdl"; //Asigno la dirección del Web Service

	$Cliente = new nusoap_client($Direccion,'wsdl');

	$Error = $Cliente->getError();
	if($Error)
	{
		echo "Error en constructor".$Error;
	}

	$Parametros = array('carnet'=> $Car, 'ciclo'=> '02', 'anio'=> '2017','clave'=> 'FvT43HOo056==423gtsWGE@&&');
	$Resultado = $Cliente->call('MostrarDatos',$Parametros);
	

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

			$objJson = (object)$Resultado["MostrarDatosResult"]["diffgram"]["DocumentElement"]["Table"];
		
			echo "
			Carnet:  ".$objJson->carnet."
			<br>Nombre:  ".$objJson->Nombre."
			<br>Apellido:  ".$objJson->Apellido1." ".$objJson->Apellido2."
			<br>Estado:  Inscrito(a) en Ciclo 02 - 2017
			<pre>";

			echo "</pre>";

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
		
				$carnet = $objJson->carnet;

            
				$sql3 = "select idreserva from reserva where idalumno = '".$carnet."' AND hora_salida IS NULL order by idreserva desc limit 0,1";

				$q = mysqli_query($connect,$sql3);
				$q = mysqli_fetch_array($q);
				$idreserva = $q["idreserva"];

				$query=mysqli_query($connect,$sql3) or die ("Imposible realizar la sentencia sql");		

				$sql = "SELECT COUNT(*) contador FROM reserva WHERE idalumno = '".$objJson->carnet."' AND hora_salida is null ";
	
				$q = mysqli_query($connect,$sql);
				$q = mysqli_fetch_array($q);
	
				if($q["contador"] == 0){
	
	
	
				$insertar = "INSERT INTO reserva (idreserva,idalumno, hora_entra, hora_salida, idsala, ciclo) VALUES (NULL, '$Car', now(), NULL, $sala, '02 2016');";
	
				$Ejecutar = mysqli_query($connect,$insertar);
				$Ejecutar = @mysqli_fetch_row($Ejecutar);
				echo "<br><h3>Marca entrada:     ".date("H:i:s")."     Sala:     ".$sala."</h3>";
				echo "<html><head><meta http-equiv=\"Refresh\" content=\"2;url=index.php?s=$sala\"></head></html>";
	
				}else{
	
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