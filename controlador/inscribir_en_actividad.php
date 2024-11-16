<?php
include_once '../modelo/actividad.php';
include_once '../modelo/user.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $idUsuario = parametroPost("idUsuario");
        $idActividad = parametroPost("idActividad"); 

        //SI no me viene un parametro declarado como NOT NULL en la BBDD, devuelvo un error
        if(!verificarUsuario($idUsuario) || !$idActividad) {
            http_response_code(400);
            return;
        }

        $actividad = obtenerActividad($idActividad);

        if(!$actividad) {
            http_response_code(404);
            return;
        }

        $usuariosInscritos = usuariosInscritosEnActividad($idActividad);
        

        if($usuariosInscritos >= $actividad["aforo"]){
            http_response_code(400);
            return;
        }

        //Incluimos el usuario en la actividad
        incluirUsuarioEnActividad($idUsuario, $idActividad);
       
    }catch(PDOException $e) {
        echo "Error en la insercion: " . $e->getMessage();
    }
}

function parametroPost($parametro) {
    if(isset($_POST[$parametro])) {
        return $_POST[$parametro];
    }
    return null;
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