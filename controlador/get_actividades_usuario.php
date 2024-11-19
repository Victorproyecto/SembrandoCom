<?php
include_once '../modelo/db_connection.php';
include_once '../modelo/actividad.php';
include_once '../modelo/user.php';
include_once '../modelo/huerto.php';
include_once 'funciones.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//validarSesionIniciada();

$conexion = crearConexion();

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    session_start();
    try {
        $id_usuario = $_SESSION['id_usuario'];
        $query = "
    SELECT 
        actividades.id,
        actividades.nombre,
        actividades.descripcion,
        actividades.direccion
    FROM 
        actividades
    JOIN 
        usuarios_actividad ON   actividades.id = usuarios_actividad.id_actividad
    WHERE 
        usuarios_actividad.id_usuario = ?
";
        $stmt = $conexion->prepare($query);  // $conexion es tu conexión MySQLi
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $conexion->error);
        }
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $actividades = [];
        $data = [];
        while ($actividad = $result->fetch_assoc()) {
            $actividades[] = $actividad;
        }

        header('Content-Type: application/json');
        echo json_encode($actividades);

    }
    catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

?>

