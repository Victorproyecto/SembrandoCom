<?php

	function crearConexion() {
		$host = "localhost";
		$user = "root";
		$pass = "";
		$baseDatos = "family_roots";

		$conexion = mysqli_connect($host, $user, $pass, $baseDatos);

        if(mysqli_connect_errno()){
            die("Error de conexión a la base de datos: " . mysqli_connect_error());
        }

		return $conexion;
	}

	function cerrarConexion($conexion) {
		mysqli_close($conexion);
	}

?>