<?php
include_once '../modelo/db_connection.php';
include_once 'funciones.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

validarSesionIniciada();

$conexion = crearConexion();

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $id_usuario = $_SESSION['id_usuario'];
        $query = "SELECT id, nombre, descripcion, direccion FROM actividades";
        $state = $conexion->prepare($query);
        $state->execute();
        $result = $state->get_result();
        if ($result->num_rows > 0) {
            // Itera sobre cada fila y muestra los datos
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
                // Muestra el contenido de cada columna
            }
        } else {
            echo "No se encontraron resultados.";
        }
        header('Content-Type: application/json');
        echo json_encode($data);

    }catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

?>

