<?php
include_once '../modelo/huerto.php';
include_once 'funciones.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

validarSesionIniciada();

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        if (isset($_GET['idCooperativa'])) {
            $idCooperativa = $_GET['idCooperativa'];
            $huertos = obtenerHuertosByCooperativa($idCooperativa);

        }else{
            $huertos = obtenerHuertos();
        }
        echo json_encode($huertos);
    }catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>