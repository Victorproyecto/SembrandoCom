<?php
include_once '../modelo/actividad.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    // Conexión a la base de datos
    $pdo = new PDO("mysql:host=localhost;dbname=nombre_base_datos", "usuario", "contraseña");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];

        // Eliminar la actividad con el ID recibido
        $sql = "DELETE FROM actividades WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Actividad eliminada con éxito']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo eliminar la actividad']);
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
