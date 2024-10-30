<?php

include_once '../modelo/db_connection.php';

$conexion = crearConexion();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_album = $_POST['id_album'];

    if($query = $conexion->prepare("SELECT nombre_album FROM albumes WHERE id_album = ?")){
        $query->bind_param('i', $id_album);
        $query->execute();
        $result = $query->get_result();

        if($row = $result->fetch_assoc()){
            echo json_encode(['success' => true, 'nombre_album' => $row['nombre_album']]);
        }else{
            echo json_encode(['success' => false, 'error' => 'Álbum no encontrado']);
        }
    }else{
        echo json_encode(['success' => false, 'error' => $conexion->error]);
    }
}else{
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no válido']);
}

cerrarConexion($conexion);

?>