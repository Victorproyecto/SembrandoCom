<?php

include_once "../modelo/db_connection.php";

//Obtener el ID de usuario de la sesión
session_start();
$idUsuario = $_SESSION['id_usuario'];

$conexion = crearConexion();
$query = "SELECT arbol_html FROM arbol WHERE id_usuario_fk = ?";  
$state = $conexion->prepare($query);
$state->bind_param("i",$idUsuario);
$state->execute();
$result = $state->get_result();


if($row = $result->fetch_assoc()){
    echo json_encode(['bentoHtml' => $row['arbol_html']]);
}else{
    http_response_code(404);
    echo json_encode(['error' => 'No se encontró el bento familiar']);
}

$state->close();
$conexion->close();
?>