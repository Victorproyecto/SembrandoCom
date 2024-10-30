<?php

include_once "../modelo/db_connection.php";

header('Content-Type: application/json');

// Manejar correctamente la visualización de errores
ini_set('display_errors', 0); // No mostrar errores directamente en la salida
error_reporting(E_ALL); // Reportar todos los errores
ob_start(); // Iniciar buffering de salida

//Comprobar si el usuario ha iniciado sesión 
session_start();
if(!isset($_SESSION['id_usuario'])){
    echo json_encode(['error' => 'No has iniciado sesión']);
    exit();
}

$inputData = json_decode(file_get_contents('php://input'), true);
$idUsuario = $_SESSION['id_usuario'];
$defaultImg = '../vista/img/profile_images/profile_default.png';

$conexion = crearConexion();
$query = "INSERT INTO miembros (imagen_miembro, id_arbol_fk) VALUES (?, (SELECT id_arbol FROM arbol WHERE id_usuario_fk = ?))";
$state = $conexion->prepare($query);
$state->bind_param('si', $defaultImg, $idUsuario);

if ($state->execute()){
    //Almacenar la id del miembro en una variable para indicarla en el html
    $newMemberId = $conexion->insert_id;
    //Crear la nueva card
    $nuevaCardHTML = <<<HTML
                    <div class="card" data-id-miembro="{$newMemberId}" data-nombre-miembro="">
                        <div class="foto-nom">
                            <div class="img">
                                <img id="profile-img" src="{$defaultImg}">
                                <label for="file-input-{$newMemberId}" class="upload-label">
                                    <i class="bi bi-image"></i>
                                </label>
                                <input id="file-input-{$newMemberId}" type="file" name="profileImage" style="display: none;" onchange="uploadMemberImage({$newMemberId})">
                            </div>
                            <div class="nom"></div>
                        </div>
                        <div class="info-member">
                            <div class="personal-info">
                                <input type="text" name="nom_miembro" class="info-input" placeholder="Nombre" autocomplete="off">
                                <input type="text" name="ape_miembro" class="info-input" placeholder="Apellidos" autocomplete="off">
                                <input type="text" name="fecha_naci" class="info-input" placeholder="Fecha de nacimiento" autocomplete="off" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <input type="text" name="fecha_falle" class="info-input" placeholder="Fecha de fallecimiento" autocomplete="off" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <input type="text" name="lugar_naci" class="info-input" placeholder="Lugar de nacimiento" autocomplete="off">
                                <input type="text" name="profesion" class="info-input" placeholder="Profesión" autocomplete="off">
                            </div>
                            <div class="parental-info">
                                <div class="relation-input-container">
                                    <input type="text" name="padre" class="parental-input"  placeholder="Padre" autocomplete="off" onblur="updateRelationInput(this)">
                                    <button class="relation-button" type="button">Padre</button>
                                </div>
                                <div class="relation-input-container">
                                    <input type="text" name="madre" class="parental-input"  placeholder="Madre" autocomplete="off" onblur="updateRelationInput(this)">
                                    <button class="relation-button" type="button">Madre</button>
                                </div>
                                <div class="relation-input-container">
                                    <input type="text" name="pareja"" class="parental-input" placeholder="Pareja" autocomplete="off" onblur="updateRelationInput(this)">
                                    <button class="relation-button" type="button">Pareja</button>
                                </div>
                                <div class="relation-input-container">
                                    <input type="text" name="hermano"o" class="parental-input" placeholder="Hermano" autocomplete="off" onblur="updateRelationInput(this)">
                                    <button class="relation-button" type="button">Hermano</button>
                                </div>
                                <div class="relation-input-container">
                                    <input type="text" name="hijo"class="parental-input" placeholder="Hijo" autocomplete="off" onblur="updateRelationInput(this)">
                                    <button class="relation-button" type="button">Hijo</button>
                                </div>
                                <div class="relation-input-container">
                                    <input type="text" name="hija"class="parental-input" placeholder="Hija" autocomplete="off" onblur="updateRelationInput(this)">
                                    <button class="relation-button" type="button">Hija</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    HTML;
    echo json_encode(['html' => $nuevaCardHTML]);
}else{
    echo json_encode(['error' => 'No se pudo crear el miembro']);
}

$state->close();
cerrarConexion($conexion);
ob_end_flush(); // Enviar salida y desactivar buffering

?>