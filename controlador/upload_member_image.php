<?php

session_start();
include_once "../modelo/db_connection.php";

header('Content-Type: application/json');

if(!isset($_SESSION['id_usuario'])){
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit();
}

if (!isset($_FILES["profileImage"]["name"]) || empty($_FILES["profileImage"]["name"])){
    echo json_encode(["error" => "No se ha seleccionado ningún archivo de imagen."]);
    exit();
}

$idMiembro = $_POST['id_miembro'] ?? null;
if(!$idMiembro){
    echo json_encode(["error" => "ID del miembro no proporcionado."]);
    exit();
}

$directorioDestino = "../vista/img/member_images/";
$archivoTemporal = $_FILES["profileImage"]["tmp_name"];
$nombreOriginal = basename($_FILES["profileImage"]["name"]);
$tipoArchivo = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
$nombreArchivo = uniqid() . '.' . $tipoArchivo;
$rutaCompleta = $directorioDestino . $nombreArchivo;

if(!in_array($tipoArchivo, ['jpg', 'jpeg', 'png', 'gif'])){
    echo json_encode(["error" => "Solo se permiten archivos JPG, JPEG, PNG o GIF"]);
    exit();
}

if (move_uploaded_file($archivoTemporal, $rutaCompleta)){
    $conexion = crearConexion();
    $query = "UPDATE miembros SET imagen_miembro = ? WHERE id_miembro = ?";
    $state = $conexion->prepare($query);
    $state->bind_param("si", $rutaCompleta, $idMiembro);
    if($state->execute()){
        echo json_encode(["imagePath" => $rutaCompleta]);
    }else{
        echo json_encode(["error" => "Error al actualizar la imagen en la bbdd"]);
    }
    $state->close();
    $conexion->close();
}else{
    echo json_encode(["error" => "Error al mover el archivo subido."]);
}

?>