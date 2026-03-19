<?php
include("conectar.php");
conectarse();
//capturar el carnet del formulario
$carnet=$_GET["carnet"];
$sala=$_GET["sala"];

echo $sala;
echo $carnet;
echo "sala=$sala<br>";

/*if($carnet==null)
die("DEBE INGRESAR UN CARNET");*/

//$carnet = substr ($carnet, 0,8);//corto el carnet ingresado
//$rex="'/([a-zA-Z]){2}([0-9]){6}/'"; //Modificaciones en la expresión
//if (preg_match($rex, $carnet, $regs))//valido que el carnet tenga 2 letras mayus o minus al principio y comparo --- CAMBIOS ereg los sustituyo por 
//{
		
		$sql="SELECT count(*) existe from alumnos where carnet = '$carnet'";
	
		//echo "sql = $sql<br>";
		$query=mysqli_query($connect,$sql) or die ("Imposible realizar la sentencia sql");
		//$numero=mysqli_num_rows($query);//NUMERO DE RESULTADO
		
   		$fechahora= date("Y-m-d H:i:s");
	    
		if($numero>0)
		{

			//$car=$carnet.".jpg";
			//verifico si el carnet tiene foto

			/*if(file_exists("FotosAlumnos/".$car))
			{echo "<img src=\"FotosAlumnos/$car\" WIDTH=140 HEIGHT=210>";
			}*/
			//else
			//{
			//
			//echo "<img src=\"FotosAlumnos/noimagen.jpg\" WIDTH=140 HEIGHT=210>";}
			//
			//echo "<br><br>";

			//$datos=mysqli_fetch_array($connect,$query);
		
			//echo $datos[4];
			echo "<br><br>";

			//VERIFICO SI EL ALUMNO TIENE HORAS
			//if($datos[3]<=0)
			die("EL ALUMNO YA NO POSEE HORAS LIBRES");
			//servicios suspendidos
			if($datos[2]==2)
			die("NO SE LE PUEDE PRESTAR SERVICIO DE HORAS LIBRES");
			//El usuario no eestaba en computo

			if($datos[2]==0)
			{
			$d=$datos[1];
			$sql="INSERT INTO reserva VALUES (0,'$d','$fechahora','',$sala,'III-2016')";
			$sql2="UPDATE alumnos SET estado=1 where carnet='$d'";
			$query=mysql_query($sql) or die (mysql_error());
			$query=mysql_query($sql2) or die (mysql_error());
			echo "MARCA ENTRADA $carnet a las $fechahora en sala $sala";
			//echo "<meta equiv=\"Refresh\" content=\"3;URL=index.php\">";
		 	//echo "<html><head><meta http-equiv=\"Refresh\" content=\"3;url=index.php?s=$sala\"></head></html>"; //refreso automáticamente
			}
		    else
		    {
			//si ya estaba en computo
			$d=$datos[1];
			//se busca por el idreserva
			$sqlreser="SELECT MAX(idreserva) FROM reserva WHERE idalumno='$d'";
			$q=mysql_query($sqlreser) or die ("primer error");
			$dat=mysql_fetch_array($q);
			//le damos la hora de salida
			$sql="UPDATE reserva SET hora_salida='$fechahora' where idreserva=$dat[0]";
			$query=mysql_query($sql) or die ("segundo error");
			//el alumno sale del computo
			$sql2="UPDATE alumnos SET estado=0 where carnet='$d'";
			$query=mysql_query($sql2) or die ("ter error");
			//restamos las horas al alumno
			$sql3= "SELECT idreserva, hora_entra, hora_salida, minute( TIMEDIFF( hora_salida, hora_entra ) ) AS m1,hour( TIMEDIFF( hora_salida, hora_entra ) ) *60 AS m2, (minute( TIMEDIFF( hora_salida, hora_entra ) ) + hour( TIMEDIFF( hora_salida, hora_entra ) ) *60) AS total FROM reserva WHERE idreserva = $dat[0]";
			$query3=mysql_query($sql3) or die (mysql_error());
     		$dat3=mysql_fetch_array($query3);

			if($datos[3]>=$dat3[5])
			$horitas=$datos[3]-$dat3[5];
			else
			$horitas=0;
			$sql4="UPDATE alumnos SET horas=$horitas where carnet='$d'";			
				mysql_query($sql4) or die (mysql_error());
			echo "MARCA SALIDA $carnet a las $fechahora";
			//que regrese si es posible
                
                
		 echo "<html><head><meta http-equiv=\"Refresh\" content=\"3;url=index.php?s=$sala\"></head></html>";
		//   echo "<meta equiv=\"Refresh\" content=\"3;URL=index.php\">";
			}
		}
		else
		{//es un alumno nuevo
		 /*$sqlin="INSERT INTO alumnos(carnet) VALUES ('$carnet')";  
			echo "sql = $sqlin<br>";
		 $queryin=mysql_query($sqlin) or die (mysql_error());
		 
		$sql="SELECT * from alumnos where carnet = '$carnet'";
		
		$query=mysql_query($sql) or die ("Imposible realizar la sentencia sql");
		$datos=mysql_fetch_array($query);
		$n=$datos[0];
		
		$sql="INSERT INTO reserva(idalumno,hora_entra,idsala) VALUES ($n,'$fechahora',$sala)";
		$query=mysql_query($sql) or die (mysql_error());
		echo "MARCA ENTRADA  $carnet a las $fechahora nuevo ingreso en sala $sala";

		 echo "<meta equiv=\"Refresh\" content=\"3;URL=pagina.html\">";*/
		 die("EL USUARIO NO ESTA INSCRITO EN EL SISTEMA");
		
		}

//}
//else
echo "EL CARNET INGRESADO ES INVALIDO";

?>


