<?php
include_once '../modelo/huerto.php';
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
        $aforo = parametroPost("aforo");


        //SI no me viene un parametro declarado como NOT NULL en la BBDD, devuelvo un error
        if(!$nombre || !$direccion || !$fecha || !verificarCooperativa($idCooperativa) || !$idHuerto || !$aforo) {
            http_response_code(400);
            return;
        }
     

        $huerto = obtenerHuerto($idHuerto);

        if(!$huerto) {
            http_response_code(404);
            return;
        }

        if($aforo > $huerto["aforo"]){
            http_response_code(400);
            return;
        }

        //Insertamos la actividad
        crearActividad($nombre, $descripcion, $direccion, $idMunicipio, $idCooperativa, $idHuerto, $fecha, $esPremium, $aforo);
        $_SESSION['mensaje'] = 'Actividad creada exitosamente';
       // Redirige de nuevo a la página de actividades
       header('Location: ../vista/actividades_cooperativas.html'); 
       exit();
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