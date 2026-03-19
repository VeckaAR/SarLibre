<?php
include '../conectar.php';

$con = conectarse();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $json_data = file_get_contents("php://input");
        $decoded = json_decode($json_data);
        $idsala = $decoded->idsala;
        
        $stmt = mysqli_prepare($con, "SELECT capacidad FROM salas WHERE idsala = ?");
        mysqli_stmt_bind_param($stmt, "i", $idsala);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $sala = mysqli_fetch_assoc($result);
        if (mysqli_errno($con) === 0) {
            echo json_encode($sala);
        } else {
            echo "Fail";
        }
        mysqli_stmt_close($stmt);
    } catch(Exception $e) {
        echo "Fail";
    }
}