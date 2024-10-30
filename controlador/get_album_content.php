<?php

include_once '../modelo/db_connection.php';

header('Content-Type: application/json');

$conexion = crearConexion();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_album = $_POST['id_album'] ?? null;

    if(!$id_album){
        echo json_encode(['success' => false, 'error' => 'ID del álbum no proporcionado']);
        exit();
    }

    // Obtener el nombre del álbum
    $query = "SELECT nombre_album FROM albumes WHERE id_album = ?";
    $state = $conexion->prepare($query);
    $state->bind_param('i', $id_album);
    $state->execute();
    $result = $state->get_result();
    $nombre_album = $result->fetch_assoc()['nombre_album'];
    $state->close();

    // Obtener las imágenes del álbum
    $query = "SELECT ruta_imagen FROM imagenes WHERE id_album_fk = ?";
    $state = $conexion->prepare($query);
    $state->bind_param('i', $id_album);
    $state->execute();
    $result = $state->get_result();
    $imagenes = [];
    while($row = $result->fetch_assoc()){
        $imagenes[] = $row['ruta_imagen'];
    }
    $state->close();

    echo json_encode(['success' => true, 'nombre_album' => $nombre_album, 'imagenes' => $imagenes]);
    cerrarConexion($conexion);
} else {
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no válido']);
}

?>
