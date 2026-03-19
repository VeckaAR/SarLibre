<?php 

	class Conexion
{
	//atributos
	private $host;
	private $user;
	private $pass;
	private $bd;

	
	public function __construct()
	{
		# code...
		$this->host = "localhost";
		$this->user = "root";
		$this->pass = "";
		$this->bd = "sar";		
	}

	function getConexion(){
		return $con = new mysqli($this->host,$this->user, $this->pass,$this->bd);

	}
	
}

 ?>