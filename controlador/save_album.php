<?php
include_once '../modelo/db_connection.php';

$conexion = crearConexion();
session_start();

header('Content-Type: application/json'); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $album_html = $_POST['album_html'];

    $query = "UPDATE album_usuario SET album_html = ? WHERE id_usuario_fk = ?";
    $state = $conexion->prepare($query);
    $state->bind_param('si', $album_html, $id_usuario);

    if ($state->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $state->error]);
    }
    $state->close();
    cerrarConexion($conexion);
}
?>
