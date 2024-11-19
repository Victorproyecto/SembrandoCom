<?php
function parametroPost($parametro) {
    if(isset($_POST[$parametro])) {
        return $_POST[$parametro];
    }
    return null;
}

function validarSesionIniciada() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION['id_usuario'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Sesion no iniciada']);
        exit();
    }
}

?>