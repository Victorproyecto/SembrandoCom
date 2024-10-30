<?php

session_start();

include_once "../modelo/db_connection.php";

header('Content-Type: application/json');

if(!isset($_SESSION['id_usuario'])){
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit();
}

$imagePath = $_POST['image_path'] ?? null;
$idAlbum = $_POST['id_album'] ?? null;

if(!$imagePath || !$idAlbum){
    echo json_encode(["error" => "Datos incompletos"]);
    exit();
}

$conexion = crearConexion();

$query = "DELETE FROM imagenes WHERE ruta_imagen = ? AND id_album_fk = ?";
$state = $conexion->prepare($query);
$state->bind_param("si", $imagePath, $idAlbum);

if($state->execute()){
    if(unlink("../vista/" . $imagePath)) {
        echo json_encode(["success" => true]);
    }else{
        echo json_encode(["error" => "No se pudo eliminar el archivo de imagen."]);
    }
}else{
    echo json_encode(["error" => "Error al eliminar la imagen de la base de datos."]);
}

$state->close();
$conexion->close();

?>