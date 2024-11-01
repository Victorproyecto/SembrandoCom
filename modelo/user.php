<?php

include_once "../modelo/db_connection.php";

//Función para verificar las credenciales del usuario
function verificarCredenciales($email, $password){
    $conexion = crearConexion();
    $query = "SELECT id_usuario, email, pass, tipo_usuario FROM usuario WHERE email=?";
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

?>