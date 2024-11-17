<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades Cooperativas - Sembrando Comunidad</title>
    <link rel="stylesheet" href="../vista/css/styles lucia.css">
    <link rel="stylesheet" href="../vista/css/styles header-footer.css">
</head>
<body>

    <!-- Header cargado dinámicamente -->
    <div id="header-placeholder"></div>

    <main class="contenedor-principal">
        <!-- Columna izquierda: Crear actividad -->
        <section class="crear-actividad">
            <h2>Crear Actividad</h2>
            <form id="form-crear-actividad" action="../controlador/crear_actividad.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre de la actividad" required>
                <textarea name="descripcion" placeholder="Descripción de la actividad" required></textarea>

                <!-- Campo desplegable para los huertos -->
                <label for="direccion-huerto">Selecciona el Huerto:</label>
                <select id="direccion-huerto" name="direccion" required>
                    <option value="">Seleccione un huerto</option>
                    <?php foreach($huertos as $huerto){?>
                        <option value='<?php echo $huerto["id"]?>'><?php echo $huerto["nombre"]?></option>
                    <?php }?>
                </select>

                <input type="date" name="fecha" required>
                <label>
                    Actividad Premium:
                    <input type="checkbox" name="esPremium" value="1">
                </label>
                <input type="number" name="aforo" placeholder="Número de voluntarios" required>

                <!-- Campos adicionales requeridos por el script PHP -->
                <input type="hidden" name="idMunicipio" value="1"> <!-- Esto debería ser dinámico -->
                <input type="hidden" name="idCooperativa" value="<?php echo $_SESSION['cooperativa']; ?>"> <!-- Debes colocar aquí el valor correcto del idCooperativa, posiblemente extraído de la sesión del usuario -->
                <input type="hidden" id="idHuerto" name="idHuerto" value=""> <!-- Actualizado dinámicamente según el huerto seleccionado -->

                <button type="submit" class="btn-crear">Crear Actividad</button>
            </form>
        </section>

        <!-- Columna derecha: Mis actividades -->
        <section class="mis-actividades">
            <h2>Mis Actividades</h2>
            <div id="actividades-container">
                <!-- Aquí se cargarán las actividades dinámicamente -->
            </div>
        </section>
    </main>

    <!-- Footer cargado dinámicamente -->
    <div id="footer-placeholder"></div>

    <!-- Script para cargar el header y footer -->
    <script src="../vista/js/header_footer.js"></script>

    <!-- Script para cargar los huertos relacionados a la cooperativa y actualizar el campo idHuerto -->
    <script>
        // Función para obtener los huertos desde el controlador
        async function fetchHuertos(idCooperativa) {
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

        // Función para mostrar los huertos en el campo de dirección (select)
        function displayHuertos(huertos) {
            const selectHuerto = document.getElementById('direccion-huerto');
            selectHuerto.innerHTML = ''; // Limpiar el contenido antes de agregar nuevas opciones

            // Crear la opción predeterminada
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.text = 'Seleccione un huerto';
            selectHuerto.appendChild(defaultOption);

            // Agregar las opciones de huertos
            huertos.forEach(huerto => {
                const option = document.createElement('option');
                option.value = huerto.id;
                option.text = huerto.nombre;
                selectHuerto.appendChild(option);
            });
        }

        // Función para actualizar el campo idHuerto dinámicamente
        function updateIdHuerto() {
            const selectHuerto = document.getElementById('direccion-huerto');
            const idHuertoInput = document.getElementById('idHuerto');

            // Actualizar el campo idHuerto cuando se selecciona un huerto
            selectHuerto.addEventListener('change', () => {
                idHuertoInput.value = selectHuerto.value;
            });
        }

        // Función para obtener las actividades desde el controlador
        async function fetchActividades(idCooperativa) {
            try {
                console.log("uu");
                const response = await fetch(`../controlador/get_actividades.php?idCooperativa=${idCooperativa}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const actividades = await response.json();
                displayActividades(actividades);
            } catch (error) {
                console.error('Hubo un problema con la petición Fetch:', error);
            }
        }


// Función para mostrar las actividades en la sección "Mis Actividades"
function displayActividades(actividades) {
    const container = document.getElementById('actividades-container');
    container.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevas actividades

    actividades.forEach(actividad => {
        
        const actividadDiv = document.createElement('div');
        actividadDiv.classList.add('actividad');
        actividadDiv.innerHTML = `
            <h3>${actividad.nombre}</h3>
            <p><strong>Descripción:</strong> ${actividad.descripcion}</p>
            <p><strong>Fecha:</strong> ${actividad.fecha}</p>
            <p><strong>Dirección:</strong> ${actividad.direccion}</p>
            <p><strong>Premium:</strong> ${actividad.esPremium ? 'Sí' : 'No'}</p>
            <button class="btn-eliminar" data-id="${actividad.id}">Eliminar</button>
        `;
        container.appendChild(actividadDiv);
    });

    // Añadir event listeners a los botones de eliminar después de agregar todas las actividades
    const deleteButtons = document.querySelectorAll('.btn-eliminar');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const idActividad = this.getAttribute('data-id');
            console.log("ID de Actividad a Eliminar:", idActividad); // Log para verificar el ID
            eliminarActividad(idActividad);
        });
    });
}

// Función para eliminar una actividad
async function eliminarActividad(id) {
    if (!confirm("¿Estás seguro de que deseas eliminar esta actividad?")) {
        return; // Si el usuario cancela, no se ejecuta la eliminación
    }

    try {
        console.log("Eliminando actividad con ID:", id); // Log para depurar

        const response = await fetch('../controlador/eliminar_actividad.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}`
        });
/*
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();

        if (result.message) {
            alert(result.message);
            // Recargar las actividades para reflejar los cambios
            fetchActividades(3); // Cambia por el idCooperativa correcto
        } else if (result.error) {
            alert(result.error);
        }
        */
        window.location.reload();
    } catch (error) {
        console.error('Hubo un problema con la petición Fetch:', error);
        alert('Hubo un problema al eliminar la actividad. Por favor, intenta nuevamente.');
    }
}

        // Llamar a las funciones para obtener los huertos y las actividades al cargar la página
        // Aquí debes usar el id de la cooperativa actual. Podrías obtenerlo de la sesión o de alguna otra forma


        const idCooperativa = <?php echo $_SESSION['cooperativa']?>;
        fetchHuertos(idCooperativa);
        fetchActividades(idCooperativa);

        // Llamar a la función para actualizar idHuerto al cargar la página
        updateIdHuerto();


    </script>
</body>
</html>
