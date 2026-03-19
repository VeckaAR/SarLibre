<?php
include("conectar.php");
conectarse();

$fechahora = date("Y-m-d H:i:s");

$sql2 = "UPDATE reserva SET hora_salida=now() where hora_salida is null";
$sql3 = "UPDATE reserva SET hora_salida=now() where hora_salida =0";

$query2 = mysqli_query($connect, $sql2) or die(mysqli_error($connect));
$query3 = mysqli_query($connect, $sql3) or die(mysqli_error($connect));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Datos</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
// Reemplaza el mensaje de éxito con SweetAlert
echo "
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Corte Realizado',
            text: '¡CORTE REALIZADO!',
            showConfirmButton: false,
            timer: 3000
        }).then(function() {
            window.location.href = 'index.php';
        });
    </script>
";
?>

</body>
</html>
