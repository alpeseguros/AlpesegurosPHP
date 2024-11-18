<?php
session_start(); // Asegúrate de que la sesión está iniciada

$is_authenticated = isset($_SESSION['user_id']);
$is_provider = isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] == 1; // Verifica si el usuario es proveedor

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/AlpeSegurosDev/index.php">
            <img src="/AlpeSegurosDev/assets/images/IMG-20241104-WA0010.jpg" alt="" width="50" height="40" class="d-inline-block align-text-top">
            AlpeSeguros
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarS"
            aria-controls="navbarS" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarS">
            <ul class="navbar-nav ms">
                <li class="nav-item"><a href="/AlpeSegurosDev/index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="/AlpeSegurosDev/src/Views/Index/quienes_somos.php" class="nav-link">¿Qué somos?</a></li>
                <li class="nav-item"><a href="/AlpeSegurosDev/src/Views/Index/contacto.php" class="nav-link">Contacto</a></li>
                <li class="nav-item"><a href="/AlpeSegurosDev/src/Views/servicios/servicios.php" class="nav-link">Servicios</a></li>
                <li class="nav-item"><a href="/AlpeSegurosDev/src/Views/Consulta/consulta.php" class="nav-link">Buscar productos</a></li>
                <li class="nav-item">
                        <a href="/AlpeSegurosDev/src/Views/Productos/agregar_productos.php" class="nav-link">Calculadora de seguros</a>
                    </li>
                <!-- Lógica para el proveedor -->
                <?php if ($is_authenticated && $is_provider): ?>
                    <li class="nav-item">
                        <span class="navbar-text">Hola proveedor, bienvenido</span>
                    </li>
                  
                    <li class="nav-item"><a href="/AlpeSegurosDev/src/Views/revisarDocumento/revisarDocumento.php" class="nav-link">Revisar documento</a></li>
                    <li class="nav-item">
                        <a href="/AlpeSegurosDev/src/Views/areaPrivada/areaPrivada.php" class="btn btn-success">Área Privada</a>
                    </li>
                    <li class="nav-item">
                        <a href="/AlpeSegurosDev/src/Views/user/logout.php" class="btn btn-danger">Cerrar sesión</a>
                    </li>
                <?php endif; ?>

                

                <!-- Lógica para el cliente -->
                <?php if ($is_authenticated && !$is_provider): ?>
                    <li class="nav-item">
                        <span class="navbar-text">Hola cliente, bienvenido</span>
                    </li>
                    <li class="nav-item">
                        <a href="/AlpeSegurosDev/src/Views/user/profile.php" class="btn btn-success">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a href="/AlpeSegurosDev/src/Views/user/logout.php" class="btn btn-danger">Cerrar sesión</a>
                    </li>
                <?php endif; ?>

                <!-- Lógica para usuarios no autenticados -->
                <?php if (!$is_authenticated): ?>
                    <li class="nav-item">
                        <a href="/AlpeSegurosDev/src/Views/user/register.php" class="btn btn-primary">Registro</a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="/AlpeSegurosDev/src/Views/user/login.php" class="btn btn-danger">Iniciar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


