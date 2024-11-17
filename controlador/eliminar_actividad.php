<?php
include_once '../modelo/actividad.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$conexion = crearConexion();

session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        // Eliminar la actividad con el ID recibido
        $sql = "DELETE FROM actividades WHERE id = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $id);
        $query->execute();
    }

} catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
}
?>