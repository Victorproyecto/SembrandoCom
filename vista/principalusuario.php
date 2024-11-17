<!DOCTYPE html>
<?php
session_start();
var_dump($_SESSION);
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi usuario - Sembrando Comunidad</title>
    <link rel="stylesheet" href="../vista/css/styles lucia.css">
    <link rel="stylesheet" href="../vista/css/styles header-footer.css">
</head>
<body>
    <!-- Header cargado dinámicamente -->
    <div id="header-placeholder"></div>
    <main class="main-perfil-usuario">
        <!-- Contenedor de dos columnas -->
        <div class="contenedor-dos-columnas">
        <!-- Sección de información del usuario -->
        <section class="seccion-usuario">
            <form action="../controlador/register.php" method="POST">
                <div class="profile-info">
                    <h2>Datos Personales</h2>
                    <ul>
                        <li>
                            <span class="label">Nombre:</span>
                            <input type="text" name="nombre" value="<?php echo $_SESSION['nombre']; ?>" placeholder="Introduce tu nombre">
                        </li>
                        <li>
                            <span class="label">email:</span>
                            <input type="text" name="email" value="<?php echo $_SESSION['email']; ?>" placeholder="Introduce tu dirección">
                        </li>
                    </ul>
                </div>

            </form>
        </section>
        </div>
        <!-- Contenedor de dos columnas -->
        <div class="contenedor-dos-columnas-body">
            <!-- Sección de nuevas ofertas -->
            <!-- Accesos directos a otras áreas -->
            <section class="accesos-areas">
                <div class="area">
                    <a href="misActividades.php">Mis actividades</a>
                </div>
                <div class="area">
                    <a href="miSuscripcion.html">Mi suscripción</a>
                </div>
            </section>
        </div>
    </main>


    <!-- Footer cargado dinámicamente -->
    <div id="footer-placeholder"></div>

    <script>


        // Función para obtener actividades desde el controlador
        async function fetchActividades() {
            try {
                console.log("u");
                const response = await fetch('../controlador/get_actividades.php');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const actividades = await response.json();
                displayActividades(actividades);
            } catch (error) {
                console.error('Hubo un problema con la petición Fetch:', error);
            }
        }
    
        // Función para mostrar las actividades en el HTML
        function displayActividades(actividades) {
            const container = document.getElementById('actividades-container');
            container.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevas actividades
    
            actividades.forEach(actividad => {
                const actividadDiv = document.createElement('div');
                actividadDiv.classList.add('actividad');
                actividadDiv.innerHTML = `
                        <h2>${actividad.nombre}</h2>
                        <p><strong>Lugar:</strong> ${actividad.lugar}</p>
                        <p><strong>Cooperativa:</strong> ${actividad.cooperativa}</p>
                        <p><strong>Fecha:</strong> 09/10/25</p>
                    `;
                container.appendChild(actividadDiv);
            });
        }
    
        // Llamar a la función para obtener actividades al cargar la página
        fetchActividades();
    </script>

    <script src="../vista/js/header_footer.js"></script>
</body>
</html>
