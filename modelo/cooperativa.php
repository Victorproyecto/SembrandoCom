<?php

include_once "../modelo/db_connection.php";

function obtenerCooperativa($id){
    $conexion = crearConexion();
    $query = "SELECT * FROM cooperativas WHERE id = ?";
    $state = $conexion->prepare($query);
    $state -> bind_param('i', $id);
    $state->execute();
    $result = $state->get_result();
    $cooperativa = null;
    if ($result->num_rows > 0) {
        $cooperativa = $result->fetch_assoc();
    }
    return $cooperativa;
}

    function guardarCooperativa($nombre, $direccion, $descripcion, $id_usuario) {
        // Crear la conexión con la base de datos
        $conexion = crearConexion();
        // Consulta SQL para insertar los datos
        $query = "UPDATE cooperativas SET nombre = ?, direccion = ?, descripcion = ? WHERE id_usuario = ?";
        // Preparar la consulta
        $state = $conexion->prepare($query);
        // Vincular los parámetros a la consulta preparada
        $state->bind_param('sssi', $nombre, $direccion, $descripcion, $id_usuario); // 'sss' indica que son tres parámetros de tipo string
        // Ejecutar la consulta
        $resultado = $state->execute();
        // Verificar si la inserción fue exitosa
        if ($resultado) {
            return true; // Inserción exitosa
        } else {
            return false; // Ocurrió un error
        }

}

?>