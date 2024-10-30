<?php

include_once "../modelo/db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['bentoHtml'])) {
    $bentoHtml = $data['bentoHtml'];

    //Obtener el ID de usuario de la sesión
    session_start();
    $idUsuario = $_SESSION['id_usuario'];

    $conexion = crearConexion();
    $query = "UPDATE arbol SET arbol_html = ? WHERE id_usuario_fk = ?";
    $state = $conexion->prepare($query);
    $state->bind_param("si", $bentoHtml, $idUsuario);
    if($state->execute()){
        echo json_encode(['message' => 'Bento guardado con éxito']);
    }else{
        http_response_code(500);
        echo json_encode(['error' => 'Error al guardar los datos en la base de datos']);
    }
    $state->close();
    $conexion->close();
}else{
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
}

?>