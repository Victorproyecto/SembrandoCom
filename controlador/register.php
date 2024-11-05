<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "../modelo/db_connection.php";
//Verifica si se ha enviado el formulario
$_POST['is_admin'] = 1;

    //Recupera los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fecha_nacimiento = $_POST['fecha'];
    $is_admin = $_POST['is_admin'];
    $defaultImg = '../vista/img/profile_images/profile_default.png';

    //Generar hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    //Insertar los datos en la bbdd
try {
    //Insertar los datos en la bbdd
    $conexion = crearConexion();
    $query = $conexion->prepare("INSERT INTO usuario (nom_usuario, email, pass, fecha_nacimiento, imagen_perfil, is_admin) VALUES (?, ?, ?, ?, ?, ?)");

    $query->bind_param("ssssss", $nombre, $email, $hashed_password, $fecha_nacimiento, $defaultImg, $is_admin);
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
header("Location: ../vista/actividades.html");
exit();
?>