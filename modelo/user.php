<?php

include_once "../modelo/db_connection.php";

//Función para verificar las credenciales del usuario
function verificarCredenciales($email, $password){
    $conexion = crearConexion();
    $query = "SELECT id, correo_electronico, password, es_premium FROM usuarios WHERE correo_electronico=?";
    $state = $conexion -> prepare($query);

    //Vincula los parámetros y ejecuta la consulta
    $state -> bind_param('s', $email);;
    $state -> execute();

    //Obtiene el resultado de la consulta
    $resultado = $state->get_result();
    cerrarConexion($conexion);
    //Devuelve el resutlado de la consulta como array
    return $resultado->fetch_assoc();
}

//Funcion para verificar las pass con el hash de la bbdd
function verificarPass($password, $hash){
    //Verifica si la pass coincide con la almacenada en la bbdd
    return password_verify($password, $hash);
    //password_verify($password, $hash);
}

//Recuperar los datos del usuario
function getUserData($idUsuario){
    $conexion = crearConexion();
    $query = "SELECT u.nom_usuario, u.ape_usuario, u.fecha_nacimiento, u.email, u.imagen_perfil, m.id_miembro FROM usuario u INNER JOIN arbol a ON u.id_usuario = a.id_usuario_fk INNER JOIN miembros m ON a.id_arbol = m.id_arbol_fk WHERE u.id_usuario = ?";
    $state = $conexion->prepare($query);
    $state -> bind_param('i', $idUsuario);
    $state -> execute();
    $resultado = $state -> get_result();
    $usuario = $resultado -> fetch_assoc();
    cerrarConexion($conexion);
    return $usuario;
}

function obtenerUsuario($idUsuario) {
    $conexion = crearConexion();
    $query = "SELECT count(*) FROM usuarios WHERE id = ?";
    $state = $conexion->prepare($query);
    $state -> bind_param('i', $idUsuario);
    $state->execute();
    $result = $state->get_result();
    $usuario = null;
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    }
    return $usuario;
}

function obtenerIdByEmail($email) {
    $conexion = crearConexion();
    $query = "SELECT id FROM usuarios WHERE correo_electronico = ?";
    $state = $conexion->prepare($query);
    $state -> bind_param('s', $email);
    $state->execute();
    $result = $state->get_result();

    return $result->fetch_assoc()['id'];
}

function obtenerNombreById($id) {
    $conexion = crearConexion();
    $query = "SELECT nombre FROM usuarios WHERE id = ?";
    $state = $conexion->prepare($query);
    $state -> bind_param('i', $id);
    $state->execute();
    $result = $state->get_result();
    return $result->fetch_assoc()['nombre'];
}

function esCooperativa($id) {

    $conexion = crearConexion();
    $sql = "SELECT id FROM cooperativas WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['id'];// fetch_row() devuelve un array numerado
  // Verificar si el usuario existe
}

function verificarCooperativa($id) {

    $conexion = crearConexion();
    $sql = "SELECT id FROM cooperativas WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

?>