<?php
include_once '../modelo/db_connection.php';

$conexion = crearConexion();

session_start();

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_usuario = $_SESSION['id_usuario'];
    $query = "SELECT album_html FROM album_usuario WHERE id_usuario_fk = ?";
    $state = $conexion->prepare($query);
    $state->bind_param('i', $id_usuario);
    $state->execute();
    $result = $state->get_result();
    $row = $result->fetch_assoc();
    if($row){
        echo json_encode(['success' => true, 'album_html' => $row['album_html']]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se encontro el contenido html']);
    }
    cerrarConexion($conexion);

}


?>
