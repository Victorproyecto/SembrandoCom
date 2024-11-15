<?php
include_once '../modelo/huerto.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $huertos = obtenerHuertos();
        echo json_encode($huertos);
    }catch(PDOException $e) {
        echo "Error en la seleccion: " . $e->getMessage();
    }
}
?>