<?php 

/**
* 
*/
class Reserva
{
	private $idAlumno;
	private $horaEntra;
	private $horaSalida;
	private $idSala;
	private $ciclo;
	
	function __construct($idR,$idA,$horaE,$horaS,$sala,$ciclo)
	{
		# code...
		$this->idReserva = $idR;
		$this->idAlumno = $idA;
		$this->horaEntra = $horaE;
		$this->horaSalida = $horaS;
		$this->idSala = $sala;
		$this->ciclo = $ciclo;
	}
	


	public function getIdReserva(){
		return $this->idReserva;
	}

	public function setIdReserva($idReserva){
		$this->idReserva = $idReserva;
	}

	public function getIdAlumno(){
		return $this->idAlumno;
	}

	public function setIdAlumno($idAlumno){
		$this->idAlumno = $idAlumno;
	}

	public function getHoraEntra(){
		return $this->horaEntra;
	}

	public function setHoraEntra($horaEntra){
		$this->horaEntra = $horaEntra;
	}

	public function getHoraSalida(){
		return $this->horaSalida;
	}

	public function setHoraSalida($horaSalida){
		$this->horaSalida = $horaSalida;
	}

	public function getIdSala(){
		return $this->idSala;
	}

	public function setIdSala($idSala){
		$this->idSala = $idSala;
	}

	public function getCiclo(){
		return $this->ciclo;
	}

	public function setCiclo($ciclo){
		$this->ciclo = $ciclo;
	}

}
	
 ?>