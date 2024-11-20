<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include_once '../modelo/user.php';
error_reporting(E_ALL);

include_once "../modelo/db_connection.php";
//Verifica si se ha enviado el formulario
//$_POST['is_admin'] = 1;

    //Recupera los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fecha_nacimiento = $_POST['fecha'];
    if (isset($_POST['admin'])) {
       $cooperativa = true;
    } else {
        $cooperativa = false;
    }

    //Generar hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    //Insertar los datos en la bbdd
try {
    //Insertar los datos en la bbdd
    $conexion = crearConexion();
    $query = $conexion->prepare("INSERT INTO usuarios (nombre, correo_electronico, password, fecha_nacimiento, es_premium) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sssss", $nombre, $email, $hashed_password, $fecha_nacimiento, $is_admin);
    $query->execute();
    $lastUserId = $conexion->insert_id;
}catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    return;
}
if($cooperativa)
    try {
            // Preparar la consulta para insertar el id_usuario
            $query = $conexion->prepare("INSERT INTO cooperativas (id_usuario nombre) VALUES (?,?)");

            // Verificar que la preparación de la consulta fue exitosa
            if ($query === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            // Enlazar el parámetro (usamos "i" para entero)
            $query->bind_param("i", $lastUserId);

            // Ejecutar la consulta
       $query->execute();


    }catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
        return;
    }

//Una vez registrado mantener la sesión iniciada.
try {
    session_start();
    $id_usuario = $lastUserId;
    $_SESSION['id_usuario'] = $id_usuario;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['cooperativa'] = esCooperativa($id_usuario);
    $_SESSION['email'] = $email;


}catch (PDOException $e) {
    // Manejo de errores en caso de fallo en la ejecución
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    return;
}
 // Redirigir según el tipo de usuario
 if ($cooperativa == "cooperativa") {
    header("Location: ../controlador/get_cooperativa.php");
    exit();
} else {
    header("Location: ../vista/principalusuario.php");
    exit();
}

?>