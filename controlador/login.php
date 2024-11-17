<?php
include_once '../modelo/user.php';
//Iniciar sesión
session_start();

//Verificar si se ha enviado el formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //Recupera los datos del formulario
    $email = $_POST["email"];
    $password = $_POST["password"];

    require_once "../modelo/user.php";

    //Verificar las credenciales del usuario
    $usuario = verificarCredenciales($email, $password);

    //Verificar la contraseña
    if($usuario && verificarPass($password, $usuario['password'])) {
        //Las credenciales son validas, iniciar sesión
        $_SESSION['id_usuario'] = obtenerIdByEmail($email);
        $_SESSION['email'] = $email;
        $_SESSION['nombre'] = obtenerNombreById($_SESSION['id_usuario']);
        $_SESSION['cooperativa'] =esCooperativa($_SESSION['id_usuario']);
        unset($_SESSION['error_login']);

        //Redirige a la pagina de perfil de usuario.
 // Redirigir según el tipo de usuario
 if ($_SESSION['cooperativa'] === true || $_SESSION['cooperativa'] === 1) {
    header("Location: ../vista/principalcooperativas.php");
    exit();
} else {
    header("Location: ../vista/principalusuario.php");
    exit();
}
    }else{
        //Contraseña o email incorrectos
        $_SESSION['error_login'] = "El correo electrónico o la contraseña son incorrectos.";
        header("Location: ../vista/login.html?error=1");
        exit();
    }
}

?>