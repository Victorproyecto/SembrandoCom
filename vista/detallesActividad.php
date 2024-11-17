<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Actividad - Sembrando Comunidad</title>
    <link rel="stylesheet" href="../vista/css/styles lucia.css">
    <link rel="stylesheet" href="../vista/css/styles header-footer.css">
</head>
<body>

    <!-- Header cargado dinámicamente -->
    <div id="header-placeholder"></div>

    <main>
        <!-- Sección de Detalles de la Actividad -->
        <section class="detalles-actividad">
            <h1><?php echo $actividad["nombre"] ?></h1>
            
            <div class="info-actividad">
                <p><strong>Fecha:</strong><?php echo $actividad["fecha"] ?></p>
                <p><strong>Ubicación:</strong><?php echo $actividad["direccion"] ?></p>
                <p><strong>Capacidad:</strong><?php echo $actividad["aforo"] ?></p>
                <p><strong>Organizado por:</strong><?php echo $cooperativa["nombre"] ?></p>

            </div>
            <div class="descripcion-actividad">
                <p><?php echo $actividad["descripcion"] ?></p>
            </div>

            <div class="tipo-actividad premium">
                <?php 
                    if($actividad["es_premium"] == 0) {
                        echo "Gratuita";
                    } 
                    else {
                        echo "Premium";
                    }
                ?>
            </div>
            
            <button class="btn-inscripcion">Inscribirse</button>
        </section>
    </main>

    <!-- Footer cargado dinámicamente -->
    <div id="footer-placeholder"></div>

    <script src="../vista/js/header_footer.js"></script>
</body>
</html>
