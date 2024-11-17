<?php 
include_once '../modelo/cooperativa.php';
include_once 'funciones.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

validarSesionIniciada();


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idCooperativa = 1;
    try {
        $cooperativa = obtenerCooperativa($idCooperativa);
        include '../vista/principalcooperativas.php';
    }catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>