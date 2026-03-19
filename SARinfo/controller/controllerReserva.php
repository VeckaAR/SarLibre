<?php 


	include_once('ReservaManagement.php');

	 function mostrarPorAlumno($id, $fecha1, $fecha2)
	{
		# code...
		$reservaManagement = new ReservaManagement();
		$lista = $reservaManagement->mostrarAlumno($id, $fecha1, $fecha2);
		$i = 0;
		if (is_null($lista)) {
			# code...
			echo "<div class='jumbotron jumbotron-fluid'>
      				<div class='container'>
        				<h1 class='display-3'>Registros no encontrados</h1>
        				<p class='lead'>El alumno no cuenta con registros, puede probar con otro rango de fecha</p>
      				</div>
    			</div>";
		}else{
			echo "
			<table class='table table-striped' id='demo' >
      			<thead>
        			<tr>
          			<th>#</th>
          			<th>Carnet</th>
          			<th>F/H Entrada</th>
          			<th>F/H Salida</th>
          			<th>Sala</th>
          			<th>Ciclo</th>
        			</tr>
      			</thead>
    		<tbody id='tabla'> ";
			foreach ($lista as $tmp) {
			# code...
				$i++;

				echo "<tr>";
				echo "<th scope='row'>".$i."</th>";	
				echo "<td>". $tmp->getIdAlumno() . "</td>";
				echo "<td>". $tmp->getHoraEntra() . "</td>";
				echo "<td>". $tmp->getHoraSalida() . "</td>";
				echo "<td>". $tmp->getIdSala() . "</td>";
				echo "<td>". $tmp->getCiclo() . "</td>";
				echo "</tr>";		

		}

		echo "
			</tbody>
		    <tr class='demo5'>	</tr>
    		</table>

		";
	}
	}


	function mostrarInfoGeneral($fecha1,$fecha2)
	{
		# code...
		$reservaManagement = new ReservaManagement();
		$lista = $reservaManagement->mostrarInforme($fecha1, $fecha2);
		$i = 0;
		if (is_null($lista)) {
			# code...
			echo "<div class='jumbotron jumbotron-fluid mt-5'>
      				<div class='container'>
        				<h1 class='display-3'>Registros no encontrados</h1>
        				<p class='lead'>El alumno no cuenta con registros, puede probar con otro rango de fecha</p>
      				</div>
    			</div>";
		}else{
			echo "
			<table class='table table-striped' id='demo' >
      			<thead>
        			<tr>
          			<th>#</th>
          			<th>Carnet</th>
          			<th>F/H Entrada</th>
          			<th>F/H Salida</th>
          			<th>Sala</th>
          			<th>Ciclo</th>
        			</tr>
      			</thead>
    		<tbody id='tabla'> ";
			foreach ($lista as $tmp) {
			# code...
				$i++;

				echo "<tr>";
				echo "<th scope='row'>".$i."</th>";	
				echo "<td>". $tmp->getIdAlumno() . "</td>";
				echo "<td>". $tmp->getHoraEntra() . "</td>";
				echo "<td>". $tmp->getHoraSalida() . "</td>";
				echo "<td>". $tmp->getIdSala() . "</td>";
				echo "<td>". $tmp->getCiclo() . "</td>";
				echo "</tr>";		

		}

		echo "
			</tbody>
		    <tr class='demo5'>	</tr>
    		</table>

		";
	}
	}


 ?>