<?php

include_once '../modelo/db_connection.php';

$conexion = crearConexion();

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_usuario = $_SESSION['id_usuario'];

    // Obtener el id_album_user correspondiente al id_usuario
    $query_user_album = "SELECT id_album_user FROM album_usuario WHERE id_usuario_fk = ?";
    $state_user_album = $conexion->prepare($query_user_album);
    $state_user_album->bind_param('i', $id_usuario);
    $state_user_album->execute();
    $state_user_album->store_result();
    $state_user_album->bind_result($id_album_user);
    $state_user_album->fetch();
    $state_user_album->close();

    if (!$id_album_user) {
        echo json_encode(['success' => false, 'error' => 'No se encontró el registro de album_usuario para este usuario.']);
        cerrarConexion($conexion);
        exit();
    }

    //Insertar un nuevo album
    $query = "INSERT INTO albumes (nombre_album, id_album_user_fk) VALUES ('', ?)";
    $state = $conexion->prepare($query);
    $state->bind_param('i', $id_album_user);

    if ($state->execute()) {
        $album_id = $state->insert_id;

        //Obtener el nombre del album, si aun no se ha introducido ninguno que salga vacío por defecto
        $nombre_album = '';

        $html = '
                <div class="album" data-id-album="' . $album_id . '">
                    <div class="nom-album">
                        <input type="text" class="album-tittle" value="' . $nombre_album . '" placeholder="Nombre del álbum">
                    </div>
                    <div class="lil-img-cont"></div>
                </div>';
                
                    //Actualizar el album_html en la bbdd
                    $query_update = "UPDATE album_usuario SET album_html = CONCAT(IFNULL(album_html, ''), ?) WHERE id_usuario_fk = ?";
                    $state_update = $conexion->prepare($query_update);
                    $state_update->bind_param('si', $html, $id_album_user);
                    $state_update->execute();
                    $state_update->close();

        echo json_encode(['success' => true, 'album_id' => $album_id, 'html' => $html]);
    } else {
        echo json_encode(['success' => false, 'error' => $state->error]);
    }
    $state->close();
    cerrarConexion($conexion);
}

?>