<?php
include("conectar.php");

$con = conectarse();

$carnet = isset($_REQUEST["carnet"]) ? trim($_REQUEST["carnet"]) : "";
$sala   = isset($_REQUEST["sala"]) ? (int)$_REQUEST["sala"] : 0;

$fechahora = date("Y-m-d H:i:s");
$ciclo = "01-2023"; // cámbialo cuando corresponda

function mostrarMensaje($titulo, $mensaje, $sala, $tipo = "info") {
    $color = "#184391";
    if ($tipo === "error") $color = "#d9534f";
    if ($tipo === "ok") $color = "#1f8b4c";

    echo '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="3;url=index.php?s=' . htmlspecialchars($sala) . '">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reserva</title>
        <style>
            body{
                margin:0;
                font-family:Arial, sans-serif;
                background:#eef1f5;
                display:flex;
                align-items:center;
                justify-content:center;
                min-height:100vh;
            }
            .card{
                background:#fff;
                width:min(500px, 92%);
                padding:30px;
                border-radius:18px;
                box-shadow:0 10px 30px rgba(0,0,0,.12);
                text-align:center;
            }
            h2{
                margin:0 0 12px;
                color:' . $color . ';
            }
            p{
                margin:0;
                font-size:18px;
                color:#243041;
                line-height:1.5;
            }
            .small{
                margin-top:16px;
                font-size:14px;
                color:#6b7280;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <h2>' . htmlspecialchars($titulo) . '</h2>
            <p>' . $mensaje . '</p>
            <p class="small">Serás redirigido automáticamente...</p>
        </div>
    </body>
    </html>';
    exit;
}

if ($carnet === "" || $sala <= 0) {
    mostrarMensaje("Datos inválidos", "Debes ingresar un carnet y seleccionar una sala válida.", $sala, "error");
}

try {
    mysqli_begin_transaction($con);

    $stmt = mysqli_prepare($con, "SELECT carnet, estado, horas FROM alumnos WHERE carnet = ?");
    mysqli_stmt_bind_param($stmt, "s", $carnet);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $alumno = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    if (!$alumno) {
        mysqli_rollback($con);
        mostrarMensaje("Alumno no encontrado", "El usuario no está inscrito en el sistema.", $sala, "error");
    }

    $estado = (int)$alumno["estado"];
    $horas  = (int)$alumno["horas"];
    $idalumno = $alumno["carnet"]; // se conserva la lógica vieja usada por reserva.idalumno

    if ($horas <= 0) {
        mysqli_rollback($con);
        mostrarMensaje("Sin horas disponibles", "El alumno ya no posee horas libres.", $sala, "error");
    }

    if ($estado === 2) {
        mysqli_rollback($con);
        mostrarMensaje("Servicio suspendido", "No se le puede prestar servicio de horas libres.", $sala, "error");
    }

    if ($estado === 0) {
        $stmt = mysqli_prepare($con, "INSERT INTO reserva (idalumno, hora_entra, hora_salida, idsala, ciclo) VALUES (?, ?, '', ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssis", $idalumno, $fechahora, $sala, $ciclo);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($con, "UPDATE alumnos SET estado = 1 WHERE carnet = ?");
        mysqli_stmt_bind_param($stmt, "s", $idalumno);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_commit($con);
        mostrarMensaje(
            "Marca de entrada registrada",
            "Se registró la entrada de <strong>" . htmlspecialchars($carnet) . "</strong> a las <strong>" . htmlspecialchars($fechahora) . "</strong> en la sala <strong>" . htmlspecialchars($sala) . "</strong>.",
            $sala,
            "ok"
        );
    } else {
        $stmt = mysqli_prepare($con, "SELECT idreserva FROM reserva WHERE idalumno = ? ORDER BY idreserva DESC LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $idalumno);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $reserva = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);

        if (!$reserva) {
            mysqli_rollback($con);
            mostrarMensaje("Error de reserva", "No se encontró una reserva activa para este alumno.", $sala, "error");
        }

        $idreserva = (int)$reserva["idreserva"];

        $stmt = mysqli_prepare($con, "UPDATE reserva SET hora_salida = ? WHERE idreserva = ?");
        mysqli_stmt_bind_param($stmt, "si", $fechahora, $idreserva);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($con, "UPDATE alumnos SET estado = 0 WHERE carnet = ?");
        mysqli_stmt_bind_param($stmt, "s", $idalumno);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($con, "SELECT TIMESTAMPDIFF(MINUTE, hora_entra, hora_salida) AS total FROM reserva WHERE idreserva = ?");
        mysqli_stmt_bind_param($stmt, "i", $idreserva);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $tiempo = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);

        $minutosConsumidos = isset($tiempo["total"]) ? (int)$tiempo["total"] : 0;
        $horitas = max($horas - $minutosConsumidos, 0);

        $stmt = mysqli_prepare($con, "UPDATE alumnos SET horas = ? WHERE carnet = ?");
        mysqli_stmt_bind_param($stmt, "is", $horitas, $idalumno);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_commit($con);
        mostrarMensaje(
            "Marca de salida registrada",
            "Se registró la salida de <strong>" . htmlspecialchars($carnet) . "</strong> a las <strong>" . htmlspecialchars($fechahora) . "</strong>.",
            $sala,
            "ok"
        );
    }

} catch (Throwable $e) {
    mysqli_rollback($con);
    mostrarMensaje("Error del sistema", "Ocurrió un problema al procesar la reserva: " . htmlspecialchars($e->getMessage()), $sala, "error");
}

desconectarse();
?>