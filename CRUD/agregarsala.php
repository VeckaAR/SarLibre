<?php
include '../conectar.php';

$con = conectarse();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents("php://input");
    $decoded = json_decode($json_data);

    if (!$decoded) {
        die("Error: no se recibió un JSON válido.");
    }

    if (!isset($decoded->numeroSala) || !isset($decoded->capacidadSala)) {
        die("Error: faltan datos requeridos.");
    }

    $numeroSala = (int)$decoded->numeroSala;
    $capacidadSala = (int)$decoded->capacidadSala;

    $stmt = mysqli_prepare($con, "INSERT INTO salas(idsala, capacidad, estado) VALUES(?, ?, 0)");

    if (!$stmt) {
        die("Error al preparar la consulta: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, "ii", $numeroSala, $capacidadSala);

    if (mysqli_stmt_execute($stmt)) {
        echo "OK";
    } else {
        die("Error al insertar: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmt);
}

desconectarse();
?>