<?php

include_once "../modelo/user.php";

session_start();

// Establecer el encabezado Content-Type a application/json
header('Content-Type: application/json');

if(isset($_SESSION['id_usuario'])){
    $idUsuario = $_SESSION['id_usuario'];
    $datosUser = getUserData($idUsuario);

    //Pasar los datos de la bbdd a JSON
    echo json_encode($datosUser);
    exit();
}else{
    echo json_encode(['error' => 'No se ha iniciado sesion.']);
}

$datosUsuario = getUserData($idUsuario);
?>