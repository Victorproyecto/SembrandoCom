<?php
include_once '../modelo/db_connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conexion = crearConexion();

session_start();

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $result = obtenerResultados($conexion);
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

    }catch
        (PDOException $e) {
            // Manejo de errores en caso de fallo en la ejecución
            echo "Error en la seleccion: " . $e->getMessage();
    }
}

function obtenerResultados($conexion) {
    $state = null;
    if(isset($_GET['id'])){
        $query = "SELECT nombre, direccion, aforo FROM huertos WHERE id = ?";
        $state = $conexion->prepare($query);
        $state -> bind_param('i', $_GET['id']);
    }
    else {
        $query = "SELECT nombre, direccion, aforo FROM huertos";
        $state = $conexion->prepare($query);
    }
    $state->execute();
    return $state->get_result();
}

?>