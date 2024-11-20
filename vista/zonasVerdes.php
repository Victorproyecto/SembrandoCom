<!DOCTYPE html>
<?php
session_start();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zonas Verdes - Sembrando Comunidad</title>
    <link rel="stylesheet" href="../vista/css/styles lucia.css">
    <link rel="stylesheet" href="../vista/css/styles header-footer.css">
</head>
<body>

    <!-- Header cargado dinámicamente -->
    <div id="header-placeholder"></div>

    <main>
        <!-- Título de la sección -->
        
        <section class="seccion-huertos">
        <h2>Zonas verdes</h2>
            <!-- Lista de huertos -->
            <div id="lista-huertos">
            </div>

            <!-- Buscador y Filtro 
            <div class="buscador-filtro">
                <input type="text" class="buscador" placeholder="Buscador">
                <label for="filtro-fecha">Filtrar por:</label>
                <select id="filtro-fecha">
                    <option value="fecha">Fecha</option>
                </select>
            </div>-->
        </section>
    </main>

    <!-- Footer cargado dinámicamente -->
    <div id="footer-placeholder"></div>

</body>
</html>

<script src="../vista/js/header_footer.js"></script>

<script>
// Función para obtener huertos desde el controlador
async function fetchHuertosPublicados() {
    try {
        const response = await fetch('../controlador/get_zonas_verdes.php');
        if (!response.ok) {
            throw new Error('Error en la respuesta de la red');
        }
        const huertos = await response.json();
        displayHuertosPublicados(huertos);
    } catch (error) {
        console.error('Hubo un problema con la petición Fetch:', error);
    }
}

// Función para mostrar los huertos en el contenedor de huertos
function displayHuertosPublicados(huertos) {
    const contenedorHuertos = document.getElementById('lista-huertos');
    contenedorHuertos.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos elementos

    // Recorrer todos los huertos y agregarlos al contenedor
    huertos.forEach(huerto => {
        const huertoDiv = document.createElement('div');
        huertoDiv.classList.add('huerto');

        // Crear el contenido del huerto, como su nombre, descripción, etc.
        huertoDiv.innerHTML = `
            <h3>${huerto.nombre}</h3>
            <p><strong>Dirección:</strong> ${huerto.direccion}</p>
            <p><strong>Cooperativa:</strong> ${huerto.nombreCooperativa}</p>
            <p>${huerto.descripcion != null ? huerto.descripcion : 'Sin descripción'}</p>
        `;

        // Añadir el div del huerto al contenedor principal
        contenedorHuertos.appendChild(huertoDiv);
    });
}

// Llamar a la función para obtener y mostrar los huertos al cargar la página
document.addEventListener('DOMContentLoaded', fetchHuertosPublicados);
</script>