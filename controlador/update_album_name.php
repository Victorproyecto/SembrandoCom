<?php

include_once '../modelo/db_connection.php';

$conexion = crearConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_album = $_POST['id_album'];
    $nombre_album = $_POST['nombre_album'];

    $query = "UPDATE albumes SET nombre_album = ? WHERE id_album = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('si', $nombre_album, $id_album);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    cerrarConexion($conexion);
}

?>
