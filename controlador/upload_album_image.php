<?php

session_start();
include_once "../modelo/db_connection.php";

header('Content-Type: application/json');

if(!isset($_SESSION['id_usuario'])){
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit();
}

if (!isset($_FILES["image"]["name"]) || empty($_FILES["image"]["name"])){
    echo json_encode(["error" => "No se ha seleccionado ningún archivo de imagen"]);
    exit();
}

$idAlbum = $_POST['id_album'] ?? null;
if(!$idAlbum){
    echo json_encode(["error" => "ID del album no proporcionado"]);
    exit();
}

$directorioDestino = "../vista/img/album_images/";
$archivoTemporal = $_FILES["image"]["tmp_name"];
$nombreOriginal = basename($_FILES["image"]["name"]);
$tipoArchivo = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
$nombreArchivo = uniqid() . '.' . $tipoArchivo;
$rutaCompleta = $directorioDestino . $nombreArchivo;

//Comprobar que el archivo tiene una extensión permitida
if(!in_array($tipoArchivo, ['jpg', 'jpeg', 'png', 'gif'])){
    echo json_encode(["error" => "Solo se permiten archivos JPG, JPEG, PNG o GIF"]);
    exit();
}

if (move_uploaded_file($archivoTemporal, $rutaCompleta)){
    $conexion = crearConexion();
    $rutaImagen = 'img/album_images/' . $nombreArchivo;
    $query = "INSERT INTO imagenes (ruta_imagen, id_album_fk) VALUES (?, ?)";
    $state = $conexion->prepare($query);
    $state->bind_param("si", $rutaImagen, $idAlbum);
    if($state->execute()){
        echo json_encode(["success" => true, "imagePath" => $rutaImagen]);
    }else{
        echo json_encode(["error" => "Error al guardar la imagen en la bbdd"]);
    }
    $state->close();
    $conexion->close();
}else{
    echo json_encode(["error" => "Error al mover el archivo subido"]);
}

?>
