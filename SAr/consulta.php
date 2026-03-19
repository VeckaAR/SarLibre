<?php
include("conectar.php");
conectarse();
$carnet = @$_POST["carnet"];
echo $carnet;
if(isset($_POST["carnet"]))
{
	$carnet= $_POST["carnet"];
	$sql="select horas from alumnos where carnet ='$carnet'";
	$q=mysqli_query($connect,$sql) or die(mysql_error());
	$dat=mysqli_fetch_array($q);
	$min=$dat[0];
	$horas=intval(($min/60));
	$m=$min % 60;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MiniSAR</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body onload="form1.carnet.focus()">
<pre>
	<?php 
//print_r($dat);
	?>
</pre>
<div id="header">
	<div id="logo">
		<h1>CONSULTA DE HORAS</h1>
		<h2>MODULO DE RESERVA HORAS LIBRES </h2>
	</div>
	<div id="splash">
			<br><br>
			<div id="form01">
		 <form action="#" method="post" name="form1">
			<p>
			<label for="Carnet">Carnet: </label>
			<input type="text" id="idcarnet" name="carnet" required autofocus placeholder="Ingrese Carnet">
			<br>			
			<!--<input type="submit" value="CONSULTA HORAS"> oculto el enlace para consultar horas!--> 
			</p>
		</form>
		<p>
		<font color="white" size="4">
		<!--<?php //echo "TIEMPO DISPONIBLE... $horas".":"." $m" ?> Aquí oculto el resultado de las horas restantes!-->
		<!--<br><a href="#">Regresar</a>!-->
		</font>
		</p>
		</div>
	</div>
	<div id="menu">
		<ul>
			<li class="current_page_item"><a href="#" title="">.</a></li>
		</ul>
	</div>
</div>
<hr />
<!-- start page -->
<div id="wrapper">
<div id="page">
	<!-- start content -->
	<div id="content">
				<h2 class="title">Bienvenido a los laboratorios de informatica </h2>
	
	</div>
	
	<div style="clear: both;">&nbsp;</div>
</div>
</div><!-- end page -->
<div id="footer">
	<p class="legal">Copyright (c) 2016 UDB </p>
	<p class="credit">&nbsp;</p>
</div>
</body>
</html>
<script language="JavaScript">
        document.form1.carnet.focus();
</script>
