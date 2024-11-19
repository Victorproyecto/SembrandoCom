<?php
include_once '../modelo/actividad.php';
include_once '../modelo/user.php';
include_once 'funciones.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

validarSesionIniciada();
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {

        $idUsuario =$_POST['id_usuario'];
        $idActividad = $_POST['id_actividad'];

        //SI no me viene un parametro declarado como NOT NULL en la BBDD, devuelvo un error
       /* if(!verificarUsuario($idUsuario) || !$idActividad) {
            http_response_code(400);
            return;
        }
*/

        $actividad = obtenerActividad($idActividad);

        if(!$actividad) {
            http_response_code(404);
            return;
        }

        $usuariosInscritos = usuariosInscritosEnActividad($idActividad);

// añadir con informacion capacidad maxima
        if($usuariosInscritos >= $actividad["aforo"]){
            http_response_code(400);
            return;
        }
// cuando un usuario ya esta inscrito , lanzar un mensaje de ya inscrito


        //Incluimos el usuario en la actividad
        incluirUsuarioEnActividad($idUsuario, $idActividad);
        header('Location: ../vista/actividades.php');
    }catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}


function verificarActividad($idActividad) {
    if($idActividad) {
        if(!obtenerActividad($idActividad)) {
            return false;
        }
        return true;
    }
    else {
        return false;
    }
}

function verificarUsuario($idUsuario) {
    if($idUsuario) {
        if(!obtenerUsuario($idUsuario)) {
            return false;
        }
        return true;
    }
    else {
        return false;
    }
}
?>