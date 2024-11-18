<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huertos Cooperativas - Sembrando Comunidad</title>
    <link rel="stylesheet" href="../vista/css/styles lucia.css">
    <link rel="stylesheet" href="../vista/css/styles header-footer.css">
    

</head>
<body>

    <!-- Header cargado dinámicamente -->
    <div id="header-placeholder"></div>

    <main class="contenedor-principal">
        <!-- Columna izquierda: Crear Huerto -->
        <section class="crear-huerto">
            <h2>Crear Huerto</h2>
            <form id="form-crear-huerto" action="../controlador/crear_huerto.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre del huerto" required>
                <textarea name="direccion" placeholder="Dirección del huerto" required></textarea>
                <input type="number" name="aforo" placeholder="Aforo del huerto" required>
                
                <!-- Campos adicionales requeridos por el script PHP -->
                <input type="hidden" name="idCooperativa" value="<?php echo $_SESSION['cooperativa']; ?>">

                <button type="submit" class="btn-crear">Crear Huerto</button>
            </form>
        </section>

        <!-- Columna derecha: Mis Huertos -->
        <section class="mis-huertos">
            <h2>Mis Huertos</h2>
            <!-- Los huertos serán generados dinámicamente aquí -->
        </section>
    </main>
    

    <!-- Footer cargado dinámicamente -->
    <div id="footer-placeholder"></div>

    <!-- Script para cargar el header y footer -->
    <script src="../vista/js/header_footer_coop.js"></script>

    <!-- Script para manejar los huertos relacionados a la cooperativa -->
    <script>
        // Función para obtener los huertos desde el controlador
        async function fetchHuertos(idCooperativa) {
            console.log(idCooperativa);
            try {
                const response = await fetch(`../controlador/get_huertos.php?idCooperativa=${idCooperativa}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const huertos = await response.json();
                displayHuertos(huertos);
            } catch (error) {
                console.error('Hubo un problema con la petición Fetch:', error);
            }
        }

        // Función para mostrar los huertos en la vista (sección "Mis Huertos")
        function displayHuertos(huertos) {
            const container = document.querySelector('.mis-huertos');
            container.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos huertos

            const header = document.createElement('h2');
            header.textContent = "Mis Huertos";
            container.appendChild(header);

            huertos.forEach(huerto => {
                const huertoDiv = document.createElement('div');
                huertoDiv.classList.add('huerto');
                huertoDiv.innerHTML = `
                    <h3>${huerto.nombre}</h3>
                    <p><strong>Dirección:</strong> ${huerto.direccion}</p>
                    <p><strong>Aforo:</strong> ${huerto.aforo}</p>
                    <button class="btn-eliminar" data-id="${huerto.id}">Eliminar</button>
                `;
                container.appendChild(huertoDiv);
            });

            // Añadir event listeners a los botones de eliminar y editar
            const deleteButtons = document.querySelectorAll('.btn-eliminar');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    eliminarHuerto(id);
                });
            });

        }
        // Función para eliminar un huerto
        async function eliminarHuerto(id) {
            if (!confirm("¿Estás seguro de que deseas eliminar este huerto?")) {
                return; // Si el usuario cancela, no se ejecuta la eliminación
            }

            try {
                const response = await fetch('../controlador/eliminar_huerto.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const result = await response.json();

                window.location.reload();
            } catch (error) {
                console.error('Hubo un problema con la petición Fetch:', error);
                alert('Hubo un problema al eliminar el huerto. Por favor, intenta nuevamente.');
            }
        }





        // Llamar a la función para obtener los huertos al cargar la página
        const idCooperativa = <?php echo $_SESSION['cooperativa']?>; // Esto debe ser dinámico dependiendo de la cooperativa que esté usando la página
        fetchHuertos(idCooperativa);
    </script>
</body>
</html>
