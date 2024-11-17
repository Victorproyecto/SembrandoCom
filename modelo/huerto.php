<?php

include_once "../modelo/db_connection.php";

function obtenerHuertos(){
    $conexion = crearConexion();
    $query = "SELECT * FROM huertos";
    $state = $conexion->prepare($query);
    $state->execute();
    $result = $state->get_result();
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    }
    return $data;
}

function obtenerHuerto($id){
    $conexion = crearConexion();
    $query = "SELECT * FROM huertos WHERE id = ?";
    $state = $conexion->prepare($query);
    $state -> bind_param('i', $id);
    $state->execute();
    $result = $state->get_result();
    $huerto = null;
    if ($result->num_rows > 0) {
        $huerto = $result->fetch_assoc();
    }
    return $huerto;
}

function crearHuerto($nombre, $direccion, $idCooperativa, $aforo){
    $conexion = crearConexion();
    $query = "INSERT INTO huertos(nombre,direccion,id_cooperativa,aforo) VALUES (?,?,?,?)";
    $state = $conexion->prepare($query);
    $state -> bind_param('ssii', $nombre, $direccion, $idCooperativa, $aforo);
    return $state->execute();
}

function obtenerHuertosbyCooperativa($idCooperativa){
    $conexion = crearConexion();
    $query = "SELECT * FROM huertos WHERE id_cooperativa = ?";
    $state = $conexion->prepare($query);
    $state -> bind_param('i', $idCooperativa);
    $state->execute();
    $result = $state->get_result();
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    }
    return $data;
}


function obtenerHuertosPorCooperativa($idCooperativa){
    $conexion = crearConexion();
    $query = "SELECT * FROM huertos WHERE id_cooperativa = ?";
    $state = $conexion->prepare($query);
    $state -> bind_param('i', $idCooperativa);
    $state->execute();
    $result = $state->get_result();
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    }
    return $data;
}

?>