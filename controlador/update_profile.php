<?php

include_once "../modelo/db_connection.php";

//Verifica si se ha enviado el formulario 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Verificar que todos los datos necesarios estén presentes
    if(isset($_POST["nombre"]) && isset($_POST["apellidos"]) && isset($_POST["mail"]) && isset($_POST["new-mail"]) && isset($_POST["password"]) && isset($_POST["repite-pas"]) && isset($_POST["new-pas"]) && isset($_POST["repite-new-pas"])) {
        
        //Recupera los datos del formulario
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $mail = $_POST["mail"];
        $newMail = $_POST["new-mail"];
        $password = $_POST["password"];
        $repitPass= $_POST["repite-pas"];
        $newPass = $_POST["new-pas"];
        $repitNewPass = $_POST["repite-new-pas"];

        //Verificar que las nuevas contraseñas coinciden
        if($newPass !== $repitNewPass){
            echo "<script>alert('Las contraseñas nuevas no coinciden');</script>";
            exit();
        }

        //Verifica que la contraseña se haya repetido correctamente y no este el campo vacío(también manejado en el html con "required")
        if(empty($password) || empty($repitPass) || $password !== $repitPass) {
            echo "<script>alert('La contraseña actual no ha sido proporcionada o no coincide con la repetición');</script>";
            exit();
        }

        //Obtener el ID de usuario de la sesión
        session_start();
        $idUsuario = $_SESSION['id_usuario'];

        //Obtener la contraseña actual del usuario des de la bbdd
        $conexion= crearConexion();
        $query = "SELECT pass FROM usuario WHERE id_usuario = ?";
        $state = $conexion->prepare($query);
        $state->bind_param('i', $idUsuario);
        $state->execute();
        $result = $state->get_result();
        $userData = $result->fetch_assoc();
        $hashedPassword = $userData['pass'];

        //Verificar la contraseña actual
        if (!password_verify($password, $hashedPassword)){
            echo "<script>alert('La contraseña actual es incorrecta');</script>";
            exit();
        }

        //Hash de la nueva contraseña
        $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);

        //Actualizar los datos en la bbdd
        $query = "UPDATE usuario SET ";
        $params = array();

        //Si el input nombre esta rellenado agregarlo a la consulta
        if(!empty($nombre)){
            $query .= "nom_usuario = ?, ";
            $params[] = $nombre;
        }

        //Si el input apellidos esta rellenado agregarlo a la consulta
        if(!empty($apellidos)){
            $query .= "ape_usuario = ?, ";
            $params[] = $apellidos;
        }

        //Si el input nuevo email esta rellenado agregarlo a la consulta
        if(!empty($newMail)){
            $query .= "email = ?, ";
            $params[] = $newMail;
        }

        //Si el input nueva contraseña esta rellenado agregarlo a la consulta
        if(!empty($newPass)){
            $query .= "pass = ?, ";
            $params[] = $hashedNewPass;
        }

        //Elimina la última "," y " " de la query
        $query = rtrim($query, ", ");
        $query .= " WHERE id_usuario = ?";
        $params[] = $idUsuario;

        $state = $conexion -> prepare($query);

        //Por cada parámetro con valor añade una "s" en $params
        $types = str_repeat('s', count($params) -1) . 'i';
        $state -> bind_param($types, ...$params);

        //Ejecutar la consulta
        if($state->execute()){
            // Actualizar los datos en la tabla miembros
            $queryMiembro = "UPDATE miembros SET nom_miembro = ?, ape_miembro = ? WHERE id_arbol_fk = (SELECT id_arbol FROM arbol WHERE id_usuario_fk = ?)";
            $stateMiembro = $conexion->prepare($queryMiembro);
            $stateMiembro->bind_param('ssi', $nombre, $apellidos, $idUsuario);

            if($stateMiembro->execute()){
                echo "<script>alert('Usuario actualizado con éxito');</script>";
    
                //Redirigir a la pagina de perfil
                header("Location: ../vista/profile.html");
                exit();
            }else{
                echo "<script>alert('Error al actualizar el usuario');</script>";
            }
            $stateMiembro->close();
        }else{
            echo "<script>alert('No se han proporcionado todos los datos necesarios');</script>";
        }
        $state->close();
        cerrarConexion($conexion);
    }else{
        echo "<script>alert('No se han proporcionado todos los datos necesarios');</script>";
    }
}
?>