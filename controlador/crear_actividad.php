<?php
include_once '../modelo/huerto.php';
include_once '../modelo/municipio.php';
include_once '../modelo/cooperativa.php';
include_once '../modelo/actividad.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $nombre = parametroPost("nombre");
        $descripcion = parametroPost("descripcion");
        $direccion = parametroPost("direccion");
        $idMunicipio = parametroPost("idMunicipio");
        $idCooperativa = parametroPost("idCooperativa"); 
        $idHuerto = parametroPost("idHuerto");
        $fecha = parametroPost("fecha");
        $esPremium = parametroPost("esPremium");

        //SI no me viene un parametro declarado como NOT NULL en la BBDD, devuelvo un error
        if(!$nombre || !$direccion || !$fecha | !verificarMunicipio($idMunicipio) || !verificarCooperativa($idCooperativa) || !verificarHuerto($idHuerto)) {
            http_response_code(400);
            return;
        }

        //Insertamos la actividad
        crearActividad($nombre, $descripcion, $direccion, $idMunicipio, $idCooperativa, $idHuerto, $fecha, $esPremium);
       
    }catch(PDOException $e) {
        echo "Error en la insercion: " . $e->getMessage();
    }
}

function parametroPost($parametro) {
    if(isset($_POST[$parametro])) {
        return $_POST[$parametro];
    }
    return null;
}

function verificarMunicipio($idMunicipio) {
    if($idMunicipio) {
        if(!obtenerMunicipio($idMunicipio)) {
            return false;
        }
        return true;
    }
    else {
        return false;
    }
}

function verificarCooperativa($idCooperativa) {
    if($idCooperativa) {
        if(!obtenerCooperativa($idCooperativa)) {
            return false;
        }
        return true;
    }
    else {
        return false;
    }
}

function verificarHuerto($idHuerto) {
    if($idHuerto) {
        if(!obtenerHuerto($idHuerto)) {
            return false;
        }
        return true;
    }
    else {
        return true;
    }
}
?>