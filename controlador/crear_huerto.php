<?php
include_once '../modelo/huerto.php';
include_once '../modelo/municipio.php';
include_once '../modelo/cooperativa.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $nombre = parametroPost("nombre");
        $direccion = parametroPost("direccion");
        $idMunicipio = parametroPost("idMunicipio");
        $idCooperativa = parametroPost("idCooperativa"); 
        $aforo = parametroPost("aforo");

        if(!$nombre || !$direccion || !$aforo || !verificarMunicipio($idMunicipio) || !verificarCooperativa($idCooperativa)) {
            http_response_code(400);
            return;
        }

        crearHuerto($nombre, $direccion, $idMunicipio, $idCooperativa, $aforo);
       
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
?>