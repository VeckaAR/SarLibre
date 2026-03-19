<?php
include '../conectar.php';

$con = conectarse();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $result = mysqli_query($con, "SELECT idsala, capacidad FROM salas");
        $salas = array();
        while ($sala = mysqli_fetch_assoc($result)) {
            array_push($salas, $sala);
        }
        echo json_encode($salas);
    } catch(Exception $e) {
        echo "Fail";
    }
}
desconectarse();