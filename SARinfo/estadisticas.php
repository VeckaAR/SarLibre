<?php 

	include('controller/conexion.php');
	$con = new conexion();
	include_once 'view/header.php';
    $año = date("Y");
 ?>

	<body>
<script src="chart/code/highcharts.js"></script>
<script src="chart/code/modules/exporting.js"></script>
<section class="container">

<div id="columns" class="col-sm-9 col-md-6 col-xs-12 col-lg-6">
</div>
<div id="" class="col-sm-9 col-md-6 col-xs-12 col-lg-6 justify-content-center text-center">
<br>
<br>
<br>
    <div class="col-lg-9 col-lg-offset-2 col-md-9 justify-content-center">
    <table class="table table-striped col-md-6 col-lg-6 ">
        <thead>
            <td scope="col"><h2>#</h2></td>
            <td scope="col"><h2>Carnet</h2></td>
            <td scope="col"><h2>Entradas</h2></td>
        </thead>
     <?php 
            $sql = "SELECT idalumno as carnet, COUNT(idalumno) as total FROM reserva WHere Year(hora_entra) = $año GROUP BY carnet ORDER BY total DESC LIMIT 5";
                $res= mysqli_query($con->getConexion(),$sql);
             $i=1;   

            while ($row = mysqli_fetch_assoc($res)) {
                    # code...
                    echo "<tr> <td><h4>".$i++."</h4></td>";
                    echo "<td><h4>".strtoupper($row['carnet']);
                    echo "</h4></td><td><h4>".$row['total']."</h4></td>";

                }

                mysqli_close($con->getConexion());

         ?>
    </table>
    </div>
</div>


</section>


		
		<script type="text/javascript">

Highcharts.chart('columns', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Ingreso de Horas libres'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Usuarios (cant)'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Ingreso de horas libres: <b>{point.y:.0f} usuarios</b>'
    },
    series: [{
        name: 'Uso de Horas',
        data: [
            <?php 
        	$sql = "SELECT MonthName(hora_entra) as mes, COUNT(idreserva) as total FROM reserva WHere Year(hora_entra) = $año GROUP BY mes ORDER by Month(hora_entra) ASC";
				$res= mysqli_query($con->getConexion(),$sql);

			while ($row = mysqli_fetch_assoc($res)) {
					# code...
					echo "[";
					echo "'".$row['mes'];
					echo "', ".$row['total']." ],";

				}

				mysqli_close($con->getConexion());

         ?>
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.0f}', // one decimal
            y: 1, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});

		</script>
<?php include_once 'view/footer.php'; ?>
	</body>
</html>