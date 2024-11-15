<?php

include_once "../modelo/db_connection.php";

function crearActividad($nombre, $descripcion, $direccion, $idMunicipio, $idCooperativa, $idHuerto){
    $conexion = crearConexion();
    $query = "INSERT INTO actividades(nombre,descripcion,direccion,id_municipio,id_cooperativa,id_huerto) VALUES (?,?,?,?,?,?)";
    $state = $conexion->prepare($query);
    $state -> bind_param('sssiii', $nombre, $descripcion, $direccion, $idMunicipio, $idCooperativa, $idHuerto);
    return $state->execute();
}

?>