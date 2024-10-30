<?php

//Inicia sesión si no está iniciada
session_start();

//Destruye todas las variables de la sesión
session_destroy();

//Redirigir a index.html
header('Location: ../vista/index.html');
exit();

?>