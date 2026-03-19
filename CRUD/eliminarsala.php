<?php
include '../conectar.php';

$con = conectarse();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $json_data = file_get_contents("php://input");
        $decoded = json_decode($json_data);
        $salaEliminar = $decoded->salaEliminar;
        
        $stmt = mysqli_prepare($con, "DELETE FROM salas WHERE idsala = ?");
        mysqli_stmt_bind_param($stmt, "i", $salaEliminar);
        mysqli_stmt_execute($stmt);
        if (mysqli_errno($con) === 0) {
            echo "OK";
        } else {
            echo "Fail";
        }
        mysqli_stmt_close($stmt);
    } catch(Exception $e) {
        echo "Fail";
    }
}

desconectarse();
?>
