<?php
include_once '../modelo/huerto.php';
include_once '../modelo/cooperativa.php';
include_once '../modelo/actividad.php';
include_once 'funciones.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

validarSesionIniciada();

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
       // $_SESSION['mensaje'] = 'Actividad creada exitosamente';
       // Redirige de nuevo a la página de actividades
       header('Location: ../vista/actividades_cooperativas.php');
       exit();
    }catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
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