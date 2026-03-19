<?php 

	include('../controller/conexion.php');
	$con = new conexion();
	include_once 'header.php';
 ?>

	<body>
<script src="../chart/code/highcharts.js"></script>
<script src="../chart/code/modules/exporting.js"></script>


<div id="columns" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>



		
		<script type="text/javascript">

Highcharts.chart('columns', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Ingreso de Horas libres'
    },
    subtitle: {
        text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
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
        	$sql = "SELECT MonthName(hora_entra) as mes, COUNT(idreserva) as total FROM reserva GROUP BY mes";
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
            format: '{point.y:.0f }', // one decimal
            y: 1, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
<?php include_once 'footer.php.php'; ?>
		</script>
	</body>
</html>