<?php
// logout.php
session_start();

// Destruir la sesión
session_unset();  // Elimina las variables de sesión
session_destroy();  // Destruye la sesión

// Redirige a la página de inicio
header("Location: ../vista/index.php");
exit();
?>