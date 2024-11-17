<?php

include_once "../modelo/db_connection.php";

function crearActividad($nombre, $descripcion, $direccion, $idMunicipio, $idCooperativa, $idHuerto, $fecha, $esPremium, $aforo){
    $conexion = crearConexion();
    $query = "INSERT INTO actividades(nombre, descripcion, direccion, id_municipio, id_cooperativa, id_huerto, fecha, es_premium, aforo) VALUES (?,?,?,?,?,?,?,?,?)";
    $state = $conexion->prepare($query);
    $state -> bind_param('sssiiissi', $nombre, $descripcion, $direccion, $idMunicipio, $idCooperativa, $idHuerto, $fecha, $esPremium, $aforo);
    return $state->execute();
}

function incluirUsuarioEnActividad($idUsuario, $idActividad) {
    $conexion = crearConexion();
    $query = "INSERT INTO usuarios_actividad(id_usuario, id_actividad, fecha_inscripcion) VALUES (?,?,?)";
    $state = $conexion->prepare($query);
    $fechaActual = date('Y-m-d', time());
    $state -> bind_param('iis', $idUsuario, $idActividad, $fechaActual);
    return $state->execute();
}

function obtenerActividad($id) {
    $conexion = crearConexion();
    $query = "SELECT * FROM actividades WHERE id = ?";
    $state = $conexion->prepare($query);
    $state -> bind_param('i', $id);
    $state->execute();
    $result = $state->get_result();
    $actividad = null;
    if ($result->num_rows > 0) {
        $actividad = $result->fetch_assoc();
    }
    return $actividad;
}

function usuariosInscritosEnActividad($idActividad) {
    $conexion = crearConexion();
    $query = "SELECT count(*) FROM usuarios_actividad WHERE id_actividad = ?";
    $state = $conexion->prepare($query);
    $state -> bind_param('i', $idActividad);
    $state->execute();
    $result = $state->get_result();
    $count = 0;
    if ($result->num_rows > 0) {
        $count = $result->fetch_row()[0];
    }
    var_dump($count); die();
    return $count;
}

?>