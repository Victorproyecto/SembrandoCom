<?php

include_once "../modelo/db_connection.php";
header('Content-Type: application/json');

$inputData = json_decode(file_get_contents('php://input'), true);

if ($inputData) {
    //Member-info
    $nombre = $inputData['nom_miembro'] ?? '';
    $apellidos = $inputData['ape_miembro'] ?? '';
    $fechaNacimiento = $inputData['fecha_naci'] ?? '';
    $fechaFallecimiento = $inputData['fecha_falle'] ?? '';
    $lugarNacimiento = $inputData['lugar_naci'] ?? '';
    $profesion = $inputData['profesion'] ?? '';
    $idMiembro = $inputData['id_miembro'] ?? '';

    //Member-relation
    $padre = $inputData['padre'] ?? '';
    $madre = $inputData['madre'] ?? '';
    $pareja = $inputData['pareja'] ?? '';
    $hermano = $inputData['hermano'] ?? '';
    $hijo = $inputData['hijo'] ?? '';
    $hija = $inputData['hija'] ?? '';

    $conexion = crearConexion();

    if (!empty($idMiembro)) { 
        $query = "UPDATE miembros SET nom_miembro=?, ape_miembro=?, fecha_naci=?, fecha_falle=?, lugar_naci=?, profesion=?, padre=?, madre=?, pareja=?, hermano=?, hijo=?, hija=? WHERE id_miembro=?";
        $state = $conexion->prepare($query);
        $state->bind_param("ssssssssssssi", $nombre, $apellidos, $fechaNacimiento, $fechaFallecimiento, $lugarNacimiento, $profesion, $padre, $madre, $pareja, $hermano, $hijo, $hija, $idMiembro);
    } else {
        $query = "INSERT INTO miembros (nom_miembro, ape_miembro, fecha_naci, fecha_falle, lugar_naci, profesion, padre, madre, pareja,hermano, hijo, hija) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $state = $conexion->prepare($query);
        $state->bind_param("ssssssssssss", $nombre, $apellidos, $fechaNacimiento, $fechaFallecimiento, $lugarNacimiento, $profesion, $padre, $madre, $pareja, $hermano, $hijo, $hija);
    }

    if ($state->execute()) {
        echo json_encode(["message" => "Miembro registrado con éxito"]);
    } else {
        echo json_encode(["error" => "Error al registrar al miembro: " . $state->error]);
    }

    $state->close();
    cerrarConexion($conexion);
}else{
    echo json_encode(["error" => "No se recibieron datos válidos"]);
}

?>