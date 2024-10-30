<?php

include_once "../modelo/db_connection.php";

header('Content-Type: application/json');

$inputData = json_decode(file_get_contents('php://input'), true);

if($inputData && isset($inputData['id_miembro'])){
    $idMiembro = $inputData['id_miembro'];

    $conexion = crearConexion();

    $query = "SELECT * FROM miembros WHERE id_miembro = ?";
    $state = $conexion->prepare($query);
    $state->bind_param("i", $idMiembro);

    if ($state->execute()){
        $resultado = $state->get_result();
        $memberData = $resultado->fetch_assoc();

        echo json_encode($memberData);
    }else{
        echo json_encode(["error" => "Error al cargar los datos del miembro: " . $state->error]);
    }
    
    $state->close();
    cerrarConexion($conexion);
}else{
    echo json_encode(['error' => 'Solicitud inválida.']);
}
?>