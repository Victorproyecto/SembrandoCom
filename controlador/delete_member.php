<?php

include_once "../modelo/db_connection.php";

header('Content-type: application/json');

session_start();
if(!isset($_SESSION['id_usuario'])) {
    echo json_encode(['Error' => 'No has iniciado sesión']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$idMiembro = $data['id_miembro'] ?? null;

if($idMiembro){
    $conexion = crearConexion();
    $query = "DELETE FROM miembros WHERE id_miembro = ?";
    $state = $conexion->prepare($query);
    $state->bind_param('i', $idMiembro);
    if($state->execute()){
        echo json_encode(['success' => true]);
    }else{
        echo json_encode(['error' => 'No se pudo eliminar el miembro.']);
    }
    $state->close();
    cerrarConexion($conexion);
}else{
    echo json_encode(['error' => 'ID del miembro no proporcionado o inválido.']);
}

?>