<?php

	function crearConexion() {
		$url = getenv('JAWSDB_URL') ?: 'mysql://root:root@localhost/test';

		// Parsear la URL
		$dbparts = parse_url($url);
		
		$host = $dbparts['host'];
		$username = $dbparts['user'];
		$password = $dbparts['pass'];
		$dbname = ltrim($dbparts['path'], '/');

		$conexion = mysqli_connect($host, $username, $password, $dbname);

        if(mysqli_connect_errno()){
            die("Error de conexión a la base de datos: " . mysqli_connect_error());
        }

		return $conexion;
	}

	function cerrarConexion($conexion) {
		mysqli_close($conexion);
	}

?>