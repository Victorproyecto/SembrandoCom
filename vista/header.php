<?php
session_start();
?>
<nav class="navbar">
    <div class="logo">
        <a href="principalusuario.php">
            <img src="../vista/img/imagenes/logo.png" alt="Logo Sembrando Comunidad">
        </a>
        <div class="logo-text">
            <h1>Sembrando Comunidad</h1>
            <p>Volver a las raíces</p>
        </div>
    </div>
    <ul class="menu">
    <li><a href="../vista/principalusuario.php">Mi perfil</a>
            <ul>
                <li><a href="/vista/miSuscripcion.html">Mi suscripción</a></li>
                <?php if (isset($_SESSION['cooperativa']) && $_SESSION['cooperativa'] == true): ?>
                <li><a href="/controlador/get_cooperativa.php">Mi cooperativa</a></li>
                <?php endif; ?>
                <li><a href="/controlador/logout.php">Logout</a></li>
            </ul>
        </li>
        <li><a href="../vista/actividades.php">Actividades</a></li>
        <li><a href="../vista/zonasVerdes.php">Zonas verdes</a></li>
        <!--<li><a href="blog.html">Blog</a></li>-->
        <li><a href="../vista/ayuda.html">Ayuda</a></li>
    </ul>
</nav>
</nav>
