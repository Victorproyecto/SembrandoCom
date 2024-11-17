
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cooperativa - Sembrando Comunidad</title>
    <link rel="stylesheet" href="../vista/css/styles lucia.css">
    <link rel="stylesheet" href="../vista/css/styles header-footer.css">
</head>
<body>

    <!-- Header cargado dinámicamente -->
    <div id="header-placeholder"></div>

    <main class="main-perfil-cooperativa">
        <h2>Mi cooperativa</h2>
        <section class="principal-cooperativa">
            <form action="../controlador/get_cooperativa.php" method="POST">
                <div class="profile-info">
                    <h3>Datos Personales</h3>
                    <div>
                        <span class="label">Nombre:</span>
                        <input type="text" name="nombre" value='<?php echo $cooperativa["nombre"]?>' placeholder="Introduce tu nombre">
                    </div>
                    <div>
                        <span class="label">Dirección:</span>
                        <input type="text" name="direccion" value='<?php echo !empty($cooperativa["direccion"]) ? $cooperativa["direccion"] : ""; ?>' placeholder="Introduce tu dirección">
                    </div>
                </div>

                <div class="profile-info">
                    <h3>Descripción</h3>
                    <textarea name="descripcion" rows="4" value='<?php echo !empty($cooperativa["descripcion"]) ? $cooperativa["descripcion"] : ""; ?>' placeholder="Escribe una breve descripción sobre tu cooperativa">'<?php echo !empty($cooperativa["descripcion"]) ? $cooperativa["descripcion"] : ""; ?>'</textarea>
                </div>

                <div class="profile-footer">
                    <button type="submit">Guardar Cambios</button>
                </div>
            </form>

            <div class="profile-footer">
                <p>Última actualización: 16 de noviembre de 2024</p>
            </div>
        </section>

        <!-- Contenedor de dos columnas -->
            <!-- Sección de nuevas ofertas -->
            <!-- Accesos directos a otras áreas -->
            <section class="accesos-areas-coop">
                <div class="area-coop">
                    <a href="../vista/actividades_cooperativas.php" class="btn-area-coop">Gestionar mis actividades</a>
                    <a href="../vista/huertos_cooperativas.php"  class="btn-area-coop">Gestionar mis Huertos</a>
                </div>
            </div>
        </section>


        
        <!-- Sección principal con las tareas y solicitudes
        <section class="contenedor-principal">
            Mis Tareas
            <div class="mis-tareas">
                <h2>Mis actividades</h2>
                <div class="tarea">
                    <p><strong>Actividades</strong></p>
                    <p>Fecha</p>
                    <p>Nº voluntarios/as inscritos</p>
                    <button class="btn-tarea">Marcar como cubierta</button>
                    <button class="btn-tarea">Gestionar</button>
                </div>
                <div class="tarea">
                    <p><strong>Actividad</strong></p>
                    <p>Fecha</p>
                    <p>Nº voluntarios/as inscritos</p>
                    <button class="btn-tarea">Marcar como cubierta</button>
                    <button class="btn-tarea">Gestionar</button>
                </div>
            </div>-->

            <!-- Añadir nueva tarea 
            <div class="nueva-tarea">
                <h2>Añadir nueva actividad</h2>
                <form>
                    <input type="text" placeholder="Título tarea" required>
                    <input type="date" placeholder="Fecha" required>
                    <input type="text" placeholder="Ubicación" required>
                    <textarea placeholder="Descripción tarea" required></textarea>
                    <input type="number" placeholder="Nº voluntarios/as necesarios" required>
                    <button type="submit" class="btn-publicar">Publicar</button>
                </form>
            </div>

             Mi calendario de tareas
            <div class="mi-calendario">
                <h2>Mi calendario de tareas</h2>
                <img src="../imagenes/calendario-placeholder.png" alt="Calendario de tareas">
            </div>

             Solicitudes 
            <div class="solicitudes">
                <h2>Solicitudes</h2>
                <ul>
                    <li>Recibidas <span class="num-solicitud">2</span></li>
                    <li>No leídas <span class="num-solicitud">0</span></li>
                    <li>Rechazadas <span class="num-solicitud">0</span></li>
                    <li>Papelera <span class="num-solicitud">7</span></li>
                </ul>
            </div>

             Nuevo mensaje 
            <div class="nuevo-mensaje">
                <h2>Nuevo mensaje</h2>
                <form>
                    <input type="text" placeholder="Destinatario" required>
                    <input type="text" placeholder="Asunto" required>
                    <textarea placeholder="Cuerpo mensaje" required></textarea>
                    <button type="submit" class="btn-enviar">Enviar</button>
                </form>
            </div>

            Gestión de voluntarios 
            <div class="gestion-voluntarios">
                <h2>Gestión voluntarios/as</h2>
                <div class="filtro">
                    <label for="filtro">Filtrar por:</label>
                    <select id="filtro">
                        <option value="nombre">Nombre</option>
                        <option value="apellido">Apellido</option>
                    </select>
                </div>
                <input type="text" placeholder="Buscador">
                <div class="voluntario">
                    <p>Nombre Apellidos</p>
                    <button class="btn-contacto">Contacto</button>
                </div>
                <div class="voluntario">
                    <p>Nombre Apellidos</p>
                    <button class="btn-contacto">Contacto</button>
                </div>
            </div>
        </section>-->
    </main>

    <!-- Footer cargado dinámicamente -->
    <div id="footer-placeholder"></div>

    <script src="../vista/js/header_footer.js"></script>
</body>
</html>
