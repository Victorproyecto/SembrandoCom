<?php

session_start();
include_once "../modelo/db_connection.php";
include_once "../modelo/user.php";

//Comprueba si el usuario esta autenticado
if(!isset($_SESSION['id_usuario'])) {
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit();
}

// Verificar si se ha seleccionado un archivo
if (!isset($_FILES["profileImage"]["name"]) || empty($_FILES["profileImage"]["name"])) {
    echo json_encode(["error" => "No se ha seleccionado ningún archivo de imagen."]);
    exit();
}

$directorioDestino = "vista/img/profile_images/";
$archivoTemporal = $_FILES["profileImage"]["tmp_name"];
$nombreOriginal = basename($_FILES["profileImage"]["name"]);
$tipoArchivo = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
$nombreArchivo = uniqid() . '.' . $tipoArchivo; //Genera un nombre único para la imagen
$rutaCompleta = "../" . $directorioDestino . $nombreArchivo;

//Valida el tipo de archivo
if($tipoArchivo != "jpg" && $tipoArchivo != "png" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif" ) {
    echo json_encode(["error" => "Solo se permiten archivos JPG, JPEG, PNG & GIF."]);
    exit;
}

//Mover el archivo subido al directorio de destino
if(move_uploaded_file($archivoTemporal, $rutaCompleta)) {
    
    //Actualiza la bbdd con la ruta de imagen en la tabla usuario y en la tabla miembros
    $conexion = crearConexion();
    $conexion->begin_transaction();

    try {
        $idUsuario = $_SESSION['id_usuario'];

        // Actualizar usuario
        $queryUsuario = "UPDATE usuario SET imagen_perfil = ? WHERE id_usuario = ?";
        $stateUsuario = $conexion->prepare($queryUsuario);
        $stateUsuario->bind_param("si", $rutaCompleta, $idUsuario);
        $stateUsuario->execute();
        $stateUsuario->close();

        // Actualizar miembro
        $queryMiembro = "UPDATE miembros SET imagen_miembro = ? WHERE id_arbol_fk IN (SELECT id_arbol FROM arbol WHERE id_usuario_fk = ?)";
        $stateMiembro = $conexion->prepare($queryMiembro);
        $stateMiembro->bind_param("si", $rutaCompleta, $idUsuario);
        $stateMiembro->execute();
        $stateMiembro->close();

        // Si ambas actualizaciones son exitosas, se realiza un commit
        $conexion->commit();
        echo json_encode(["imagePath" => $rutaCompleta]);
    }catch (mysqli_sql_exception $exception){
        $conexion->rollback(); // En caso de error, se revierten todos los cambios
        echo json_encode(["error" => "Error al actualizar las tablas: " . $exception->getMessage()]);
    }
    $conexion->close();
}else{
    echo json_encode(["error" => "Error al mover el archivo subido."]);
}
?>