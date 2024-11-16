<?php
include_once '../modelo/huerto.php';
include_once '../modelo/municipio.php';
include_once '../modelo/cooperativa.php';
include_once 'funciones.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

validarSesionIniciada();

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $nombre = parametroPost("nombre");
        $direccion = parametroPost("direccion");
        $idCooperativa = parametroPost("idCooperativa"); 
        $aforo = parametroPost("aforo");

        if(!$nombre || !$direccion || !$aforo || !verificarCooperativa($idCooperativa)) {
            http_response_code(400);
            return;
        }

        crearHuerto($nombre, $direccion, $idCooperativa, $aforo);
        $_SESSION['mensaje'] = 'Actividad creada exitosamente';
        // Redirige de nuevo a la página de actividades
        header('Location: ../vista/huertos_cooperativas.html'); 
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