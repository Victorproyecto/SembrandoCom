<?php
include_once '../modelo/actividad.php';
include_once '../modelo/cooperativa.php';
include_once 'funciones.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

validarSesionIniciada();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        if(!isset($_GET["id"])){
            http_response_code(400);
            return;
        }
        $id = $_GET["id"];
        $actividad = obtenerActividad($id);
        if(!$actividad) {
            http_response_code(404);
            return;
        }

        $cooperativa = obtenerCooperativa($actividad["id_cooperativa"]);
        if(!$cooperativa) {
            http_response_code(404);
            return;
        }

        include '../vista/detallesActividad.php';
    }catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>