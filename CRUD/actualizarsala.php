<?php
include '../conectar.php';

$con = conectarse();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents("php://input");
    $decoded = json_decode($json_data);

    if (!$decoded) {
        die("Error: no se recibió un JSON válido.");
    }

    if (!isset($decoded->salaEditar) || !isset($decoded->capacidadSala)) {
        die("Error: faltan datos requeridos.");
    }

    $salaEditar = (int)$decoded->salaEditar;
    $capacidadSala = (int)$decoded->capacidadSala;

    $stmt = mysqli_prepare($con, "UPDATE salas SET capacidad = ? WHERE idsala = ?");

    if (!$stmt) {
        die("Error al preparar la consulta: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, "ii", $capacidadSala, $salaEditar);

    if (mysqli_stmt_execute($stmt)) {
        echo "OK";
    } else {
        die("Error al actualizar: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmt);
}

desconectarse();
?>