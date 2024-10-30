<?php

include_once '../modelo/db_connection.php';

$conexion = crearConexion();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_album = $_POST['id_album'];

    $query = "DELETE FROM albumes WHERE id_album = ?";
    $state = $conexion->prepare($query);
    $state->bind_param('i', $id_album);

    if($state->execute()){
        echo json_encode(['success' => true]);
    }else{
        echo json_encode(['success' => false, 'error' => $state->error]);
    }
    cerrarConexion($conexion);
}

?>