<?php
include_once '../modelo/huerto.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$conexion = crearConexion();

session_start();

try {
    // Cambia "nombre_base_datos", "usuario", "contraseña" por las credenciales correctas
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];

        // Eliminar el huerto con el ID recibido
        $sql = "DELETE FROM huertos WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Huerto eliminado con éxito']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo eliminar el huerto']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Método no permitido o parámetro ID faltante']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la conexión: ' . $e->getMessage()]);
}
?>
