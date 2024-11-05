<?php

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
    if($usuario && verificarPass($password, $usuario['pass']) && $usuario['tipo_usuario'] === 'registrado') {
        //Las credenciales son validas, iniciar sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['email'] = $usuario['email'];
        unset($_SESSION['error_login']);

        //Redirige a la pagina de perfil de usuario.
        header("Location: ../vista/actividades.html");
        exit();
    }else{
        //Contraseña o email incorrectos
        $_SESSION['error_login'] = "El correo electrónico o la contraseña son incorrectos.";
        header("Location: ../vista/login.html?error=1");
        exit();
    }
}

?>