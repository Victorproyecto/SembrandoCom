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

?>