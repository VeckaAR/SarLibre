<?php 

/**
* 
*/
class Wsmodel
{
		private $carnet;
		private $nombre;
		private $img;

	
	function __construct($carnet,$nombre,$img)
	{
		# code...
		$this->carnet = $carnet;
		$this->nombre = $nombre;
		$this->img = $img;

	}
	
	public function getCarnet(){
			return	$this->carnet;
		}

		public function setCarnet($carnet){
			$this->carnet =	$carnet;

		}
		public function getNombre(){
			return	$this->nombre;
		}

		public function setNombre($nombre){
			$this->carnet =	$nombre;

		}

		public function getImg(){
			return	$this->img;
		}

		public function setImg($img){
			$this->img =	$img;

		}

}
	
 ?>