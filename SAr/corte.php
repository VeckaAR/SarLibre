<?php
include("conectar.php");
conectarse();

		
   $fechahora= date("Y-m-d H:i:s");
	    
	
			//revisamos los id de los estudiantes que estan en el centro de computo
		  
		  $sqlcorte="select idalumno from alumnos where estado=1";
		   	$j=mysql_query($sqlcorte) or die ("no se puede realizar consulta");
			while($dd=mysql_fetch_array($j))
			{
				$d= $dd[0];
			echo "<br>";
			
			echo $d;
			
			$sqlrecursivo="select * from alumnos where idalumno=$d";
			
			$datos=mysql_fetch_array(mysql_query($sqlrecursivo));
			//se busca por el idreserva
						
			$sqlreser="SELECT MAX(idreserva) FROM reserva WHERE idalumno=$d";
			
			$q=mysql_query($sqlreser) or die ("dd");
			$dat=mysql_fetch_array($q);
			//le damos la hora de salida
			$sql="UPDATE reserva SET hora_salida='$fechahora' where idreserva=$dat[0]";
			$query=mysql_query($sql) or die (mysql_error());
			//el alumno sale del computo
			$sql2="UPDATE alumnos SET estado=0 where estado=1;
			$query=mysql_query($sql2) or die (mysql_error());
			//prestamos las horas al alumno 
			$sql3= "SELECT idreserva, hora_entra, hora_salida, minute( TIMEDIFF( hora_salida, hora_entra ) ) AS m1,
					 hour( TIMEDIFF( hora_salida, hora_entra ) ) *60 AS m2, (minute( TIMEDIFF( hora_salida, hora_entra ) ) + hour( TIMEDIFF( hora_salida, hora_entra ) ) *60) AS total FROM reserva
					WHERE idreserva = $dat[0]";
			$query3=mysql_query($sql3) or die (mysql_error());
     		$dat3=mysql_fetch_array($query3);

			if($datos[3]>=$dat3[5])
			$horitas=$datos[3]-$dat3[5];
			else
			$horitas=0;
			$sql4="UPDATE alumnos SET horas=$horitas where idalumno=$d";			
				mysql_query($sql4) or die (mysql_error());
			echo "MARCA SALIDA $datos[2] a las $fechahora";
			//que regrese si es posible
		
		 echo "<meta equiv=\"Refresh\" content=\"1;URL=index.php\">";
			}
		mysql_query("update alumnos set estado=0 where estado=1") or die (mysql_error());
		


?>


