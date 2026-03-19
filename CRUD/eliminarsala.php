<?php
include '../conectar.php';

$con = conectarse();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents("php://input");
    $decoded = json_decode($json_data);

    if (!$decoded) {
        die("Error: no se recibió un JSON válido.");
    }

    if (!isset($decoded->salaEliminar)) {
        die("Error: faltan datos requeridos.");
    }

    $salaEliminar = (int)$decoded->salaEliminar;

    $stmt = mysqli_prepare($con, "DELETE FROM salas WHERE idsala = ?");

    if (!$stmt) {
        die("Error al preparar la consulta: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, "i", $salaEliminar);

    if (mysqli_stmt_execute($stmt)) {
        echo "OK";
    } else {
        die("Error al eliminar: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmt);
}

desconectarse();
?>