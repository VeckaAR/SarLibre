<html>
  <head>

    <link href="themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="Scripts/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" />
	
	<script src="scripts/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
    <script src="Scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
	
  </head>
  <body style="width: 100%;">
	<div id="PeopleTableContainer" style="width: 90%; margin: 0 auto;"></div>
	<script type="text/javascript">

		$(document).ready(function () {

		    //Prepare jTable
			$('#PeopleTableContainer').jtable({
				title: 'Table of people',
				actions: {
					listAction: '../listEmployee.php'
				},
				fields: {
					IdALumno: {
						title: 'idAlumno',
						width: '15%'
					},
					Nombre: {
						title: 'Nombre',
						width: '20%'
					},
					Apellido: {
						title: 'apellidos ',
						width: '20%'
					},
					HoraEntra: {
						title: 'Hora Entrada',
						width: '15%'
					},
					HoraSal: {
						title: 'Hora Salida',
						width: '15%'
					},
					Sala: {
						title: 'Sala',
						width: '5%'
					},
					Ciclo: {
						title: 'ciclo',
						width: '15%'
					}
					

				}
			});

			//Load person list from server
			$('#PeopleTableContainer').jtable('load');

		});

	</script>
 
  </body>
</html>
