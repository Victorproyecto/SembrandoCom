<!DOCTYPE html>
<?php
session_start();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zonas Verdes - Sembrando Comunidad</title>
    <link rel="stylesheet" href="../vista/css/styles header-footer.css">
    <link rel="stylesheet" href="../vista/css/styles lucia.css">
</head>
<body>

    <!-- Header cargado dinámicamente -->
    <div id="header-placeholder"></div>

    <main>
        <!-- Título de la sección -->
        <section class="seccion-eventos">
            <h1>ZONAS VERDES</h1>
            <!-- Buscador y Filtro 
            <div class="buscador-filtro">
                <input type="text" class="buscador" placeholder="Buscador">
                <label for="filtro-fecha">Filtrar por:</label>
                <select id="filtro-fecha">
                    <option value="fecha">Fecha</option>
                </select>
            </div>-->

            <!-- Lista de Eventos -->
            <div class="lista-eventos">
                
            </div>
            <!-- Botón para cargar más eventos -->
            <button class="btn-mostrar-mas">Mostrar más</button>
        </section>
    </main>

    <!-- Footer cargado dinámicamente -->
    <div id="footer-placeholder"></div>

    <script src="../vista/js/header_footer.js"></script>
</body>
</html>
<script>
// Función para obtener huertos desde el controlador
async function fetchHuertosPublicados() {
    try {
        const response = await fetch('../controlador/get_huertos.php');
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
    const contenedorHuertos = document.getElementById('lista-eventos');
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
            <p>${huerto.descripcion}</p>
            <button class="btn-detalles" onclick="window.location.href='../controlador/get_huerto.php?id=${huerto.id}'">Ver Detalles</button>
        `;

        // Añadir el div del huerto al contenedor principal
        contenedorHuertos.appendChild(huertoDiv);
    });
}

// Llamar a la función para obtener y mostrar los huertos al cargar la página
document.addEventListener('DOMContentLoaded', fetchHuertosPublicados);
</script>