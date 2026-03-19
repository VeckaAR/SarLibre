<?php 
include("nusoap/lib/nusoap.php");
include('model/wsModel.php');


/**
* 
*/
class WsManagement 
{
	
	function __construct()
	{
		# code...
	}
	public function wsALumno($carnet, $fecha1)
	{
		# code...
		$año =  date("Y", strtotime($fecha1));
		$ciclo = "";
		if (date("n")>0 && date("n")<6) {
		# code...
			$ciclo = "01";
		
			}else if (date("n")>7 && date("n")<13) {
		# code...
			$ciclo = "02";
			}else $ciclo = "03";

	$url = "https://admacad.udb.edu.sv/LoginService/api/Login/DatosAlumno/{$carnet}";
	// Inicializar la solicitud CURL
	$ch = curl_init($url);

	// Configurar opciones para la solicitud CURL
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	// Ejecutar la solicitud CURL y obtener la respuesta
	$response = curl_exec($ch);

	// Comprobar si hay errores en la solicitud CURL
	if(curl_errno($ch)){
    	echo 'Error: ' . curl_error($ch);
	}

	// Cerrar la sesión CURL
	curl_close($ch);

	// Imprimir la respuesta de la API
	$resultado=(json_decode($response));
	if($resultado == null || $resultado == ""){
			$tmp = null; //asignando valores a la modelos ws
	} 
	else {
			
			$tmp = new Wsmodel($carnet,$resultado->nombre,$resultado->foto_b64); //asignando valores a la modelos ws
		}		

		return $tmp;		

	}
}


 ?>