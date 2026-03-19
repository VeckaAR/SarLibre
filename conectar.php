<?php
$host = "localhost";
$user = "root";
$clave = "";
$db = "sar";

function conectarse()
{
    global $host, $user, $clave, $db, $connect;

    $connect = mysqli_connect($host, $user, $clave, $db);

    if (!$connect) {
        die("No se puede conectar: " . mysqli_connect_error());
    }

    return $connect;
}

function desconectarse()
{
    global $connect;

    if ($connect) {
        mysqli_close($connect);
    }
}
?>



