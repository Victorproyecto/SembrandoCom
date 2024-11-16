<?php
include_once '../modelo/huerto.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    // Conexión a la base de datos
    $pdo = new PDO("mysql:host=localhost;dbname=nombre_base_datos", "usuario", "contraseña");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        // Recoger los datos enviados mediante POST
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $aforo = $_POST['aforo'];

        // Verificar que todos los parámetros requeridos están presentes
        if (!$id || !$nombre || !$direccion || !$aforo) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan parámetros requeridos']);
            exit;
        }

        // Preparar la consulta para actualizar el huerto
        $sql = "UPDATE huertos SET nombre = :nombre, direccion = :direccion, aforo = :aforo WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt->bindParam(':aforo', $aforo, PDO::PARAM_INT);

        // Ejecutar la consulta y devolver el resultado
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Huerto actualizado con éxito']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo actualizar el huerto']);
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
