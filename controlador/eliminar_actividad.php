<?php
include_once '../modelo/actividad.php';
include_once 'funciones.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

validarSesionIniciada();

header('Content-Type: application/json');

try {
    // Conexión a la base de datos
    $pdo = new PDO("mysql:host=localhost;dbname=nombre_base_datos", "usuario", "contraseña");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idActividad'])) {
        $idActividad = $_POST['idActividad'];

        // Eliminar la actividad con el ID recibido
        $sql = "DELETE FROM actividades WHERE id = :idActividad";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idActividad', $idActividad, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Actividad eliminada con éxito']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo eliminar la actividad']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Método no permitido o parámetro idActividad faltante']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
