<!DOCTYPE html>
<?php
session_start();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis actividades - Sembrando Comunidad</title>
    <link rel="stylesheet" href="../vista/css/styles header-footer.css">
    <link rel="stylesheet" href="../vista/css/styles lucia.css">

</head>
<body>
    <!-- Header cargado dinámicamente -->
    <div id="header-placeholder"></div>
    <main>
        <!-- Lista de Actividades -->
        <section class="lista-actividades">
            <h2>Mis Actividades</h2>
            <div id="actividades-container">

            </div>
            <!-- Añadir más actividades según sea necesario -->
        </section>
    </main>

    <!-- Footer cargado dinámicamente -->
    <div id="footer-placeholder"></div>

    <script src="../vista/js/header_footer.js"></script>
</body>
</html>

<script>
    // Función para obtener actividades desde el controlador
    async function fetchActividades() {
        try {
            const response = await fetch('../controlador/get_actividades_usuario.php');
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const actividades = await response.json();
            console.log(actividades);
            renderizarActividades(actividades);
        } catch (error) {
            console.error('Hubo un problema con la petición Fetch:', error);
        }
    }

    function renderizarActividades(actividades) {
        const container = document.getElementById('actividades-container');

        // Recorrer cada actividad y crear el HTML dinámicamente
        actividades.forEach(actividad => {
            const actividadDiv = document.createElement('div');
            actividadDiv.classList.add('actividad');
            actividadDiv.setAttribute('data-id', actividad.id);
            // Crear el contenido de la actividad
            actividadDiv.innerHTML = `
                    <div class="actividad-thumbnail"></div>
                    <div class="actividad-contenido">
                        <h3>${actividad.nombre}</h3>
                        <p>Organizado por: Cooperativa Verde</p>
                        <p><span>Fecha: 12/12/2023</span> | <span>Ubicación: ${actividad.direccion}</span></p>
                        <div class="tipo-actividad gratuita">Gratuita</div>
                    </div>
                `;

            // Agregar la actividad al contenedor
            container.appendChild(actividadDiv);
        });
    }

    // Llamar a la función para obtener actividades al cargar la página
    fetchActividades();
</script>