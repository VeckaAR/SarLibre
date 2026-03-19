<?php
include("conectar.php");
conectarse();

 $fechahora= date("Y-m-d H:i:s");
 
//$sql1="UPDATE alumnos set estado=0 where estado=1";//paso los alumnos a inactivos
$sql2="UPDATE reserva SET hora_salida=now() where hora_salida is null";
$sql3="UPDATE reserva SET hora_salida=now() where hora_salida =0";
$query2=mysqli_query($connect,$sql2) or die (mysqli_error($connect));
$query3=mysqli_query($connect,$sql3) or die (mysqli_error($connect));
//$query4=mysqli_query($connect,$sql4) or die (mysqli_error($connect));
echo "<h3>¡CORTE REALIZADO!</h3>";
?>
<html><head><meta http-equiv="Refresh" content="3;url=index.php"></head><body><p>SI NO REGRESAS DA CLICK <a href="index.php" /a>Aquí</p></body></html>