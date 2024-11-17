<?php 
include_once '../modelo/cooperativa.php';
include_once 'funciones.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
validarSesionIniciada();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $cooperativa = obtenerCooperativa($_SESSION['cooperativa']);
        include '../vista/principalcooperativas.php';
    }catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
        echo json_encode(['error' => $e->getMessage()]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario (POST)

    if (isset($_POST['nombre']) && isset($_POST['direccion']) && isset($_POST['descripcion'])) {
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $descripcion = $_POST['descripcion'];
        try {
            if (guardarCooperativa($nombre, $direccion, $descripcion,$_SESSION['id_usuario'])) {
                echo json_encode(['success' => 'Cooperativa guardada correctamente']);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Hubo un problema al guardar la cooperativa']);
            }
            header("Location: ../controlador/get_cooperativa.php");

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        // Si no se reciben todos los datos necesarios
        http_response_code(400);
        echo json_encode(['error' => 'Faltan datos necesarios para guardar la cooperativa']);
    }
}
?>