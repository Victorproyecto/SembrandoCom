<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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
    // Manejo de errores en caso de fallo en la ejecución
    echo "Error en la inserción:1 " . $e->getMessage();
}
if($cooperativa)
    try {
            // Preparar la consulta para insertar el id_usuario
            $query = $conexion->prepare("INSERT INTO cooperativas (id_usuario) VALUES (?)");

            // Verificar que la preparación de la consulta fue exitosa
            if ($query === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            // Enlazar el parámetro (usamos "i" para entero)
            $query->bind_param("i", $lastUserId);

            // Ejecutar la consulta
       $query->execute();


    }catch (PDOException $e) {
        // Manejo de errores en caso de fallo en la ejecución
        echo "Error en la inserción:1 " . $e->getMessage();
    }

//Una vez registrado mantener la sesión iniciada.
try {
    session_start();
    $id_usuario = $conexion->insert_id;
    $_SESSION['id_usuario'] = $id_usuario;
    $_SESSION['nombre_usuario'] = $nombre;
    $_SESSION['cooperativa'] = $cooperativa;
    $_SESSION['email'] = $usuario['email'];

}catch (PDOException $e) {
    // Manejo de errores en caso de fallo en la ejecución
    echo "Error en iniciar session php: " . $e->getMessage();
}
 //Obtener el id del arbol creado para la tabla miembros
    $id_arbol = $conexion->insert_id;
    //Registrar el usuario como primer miembro de su arbol
try {
}catch (PDOException $e) {
    // Manejo de errores en caso de fallo en la ejecución
    echo "Error en la inserción3: " . $e->getMessage();
}

try {
}catch (PDOException $e) {
    // Manejo de errores en caso de fallo en la ejecución
    echo "Error en la inserción3: " . $e->getMessage();
}

//Redirige a la pagina de perfil.
header("Location: ../vista/zonasVerdes.html");
exit();
?>