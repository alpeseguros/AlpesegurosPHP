<?php
session_start(); // Asegúrate de que la sesión está iniciada

$is_authenticated = isset($_SESSION['user_id']);
$is_provider = isset($_SESSION['tipo_cliente']) && $_SESSION['tipo_cliente'] == 1; // Verifica si el usuario es proveedor

// Inicializa el carrito en la sesión si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$carrito = [];
$total = 0;
$cantidad_productos = 0;

if ($is_authenticated) {
    // Conectar a la base de datos
    include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php';

    // Obtener datos del usuario
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT nombre, correo FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($nombre, $correo);
    $stmt->fetch();
    $stmt->close();

    // Obtener los productos en el carrito de la base de datos
    $sqlCarrito = "SELECT id, nombre_apellido, telefono, correo, direccion, producto, cantidad, fecha_agregado, id_query, precio 
                   FROM carrito_compras WHERE usuario = ? AND pagado = 1 AND in_cart = 1";
    $stmtCarrito = $conn->prepare($sqlCarrito);
    $stmtCarrito->bind_param("s", $nombre);
    $stmtCarrito->execute();
    $resultCarrito = $stmtCarrito->get_result();

    // Crear un array para los productos del carrito
    while ($row = $resultCarrito->fetch_assoc()) {
        $carrito[] = $row;
    }
    $stmtCarrito->close();

    // Calcular cantidad de productos en el carrito
    $cantidad_productos = count($carrito);

    // Calcular el total correctamente
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    $conn->close();
} else {
    // Si no está autenticado, los datos del carrito estarán vacíos
    $nombre_apellido = '';
    $telefono = '';
    $correo = '';
    $direccion = '';
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/Project/index.php">
            <img src="/Project/assets/images/ftr.png" alt="" width="50" height="40" class="d-inline-block align-text-top">
            FINCA SANA
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarS"
            aria-controls="navbarS" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarS">
            <ul class="navbar-nav ms">
                <li class="nav-item"><a href="/Project/index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="/Project/src/Views/Index/quienes_somos.php" class="nav-link">¿Qué somos?</a></li>
                <li class="nav-item"><a href="/Project/src/Views/Index/contacto.php" class="nav-link">Contacto</a></li>
                <li class="nav-item"><a href="/Project/src/Views/servicios/servicios.php" class="nav-link">Servicios</a></li>
                <li class="nav-item"><a href="/Project/src/Views/Consulta/consulta.php" class="nav-link">Buscar productos</a></li>

                <!-- Lógica para el proveedor -->
                <?php if ($is_authenticated && $is_provider): ?>
                    <li class="nav-item">
                        <span class="navbar-text">Hola proveedor, bienvenido</span>
                    </li>
                    <li class="nav-item">
                        <a href="/Project/src/Views/Productos/agregar_productos.php" class="nav-link">Agregar Producto</a>
                    </li>
                    li class="nav-item">
                        <a href="/Project/src/Views/user/profile.php" class="btn btn-success">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a href="/Project/src/Views/user/logout.php" class="btn btn-danger">Cerrar sesión</a>
                    </li>
                <?php endif; ?>

                <!-- Ícono del carrito con cantidad (visible para todos los usuarios autenticados) -->
                <?php if ($is_authenticated): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#carritoModal">
                            <i class="bi bi-cart"></i> Carrito <span class="badge bg-secondary"><?php echo $cantidad_productos; ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Lógica para el cliente -->
                <?php if ($is_authenticated && !$is_provider): ?>
                    <li class="nav-item">
                        <span class="navbar-text">Hola cliente, bienvenido</span>
                    </li>
                    <li class="nav-item">
                        <a href="/Project/src/Views/user/profile.php" class="btn btn-success">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a href="/Project/src/Views/user/logout.php" class="btn btn-danger">Cerrar sesión</a>
                    </li>
                <?php endif; ?>

                <!-- Lógica para usuarios no autenticados -->
                <?php if (!$is_authenticated): ?>
                    <li class="nav-item">
                        <a href="/Project/src/Views/user/register.php" class="btn btn-primary">Registro</a>
                    </li>
                    <li class="nav-item">
                        <a href="/Project/src/Views/user/login.php" class="btn btn-danger">Iniciar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<!-- Modal del carrito -->
<div class="modal fade" id="carritoModal" tabindex="-1" aria-labelledby="carritoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="carritoModalLabel">Carrito de Compras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if ($cantidad_productos > 0): ?>
                    <ul class="list-group">
                        <?php foreach ($carrito as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <?php echo htmlspecialchars($item['producto']); ?> (<?php echo $item['cantidad']; ?>)
                                    <span><?php echo number_format($item['precio'] * $item['cantidad'], 2); ?> $</span>
                                </div>
                                <!-- Botón de eliminar -->
                                <button class="btn btn-danger btn-sm ms-3 eliminar-item" data-id="<?php echo $item['id']; ?>">Eliminar</button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="mt-3">
                        <strong>Total:</strong> <?php echo number_format($total, 2); ?> $
                    </div>
                    <div class="mt-3 text-center">
                        <a href="/Project/src/Controllers/checkout.php" class="btn btn-success">Finalizar Compra</a>
                    </div>
                <?php else: ?>
                    <p>El carrito está vacío.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Script para manejar el botón de eliminar
document.querySelectorAll('.eliminar-item').forEach(button => {
    button.addEventListener('click', function() {
        const itemId = this.getAttribute('data-id');
        fetch('/Project/src/Controllers/eliminar_del_carrito.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: itemId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Recargar la página después de eliminar
            } else {
                alert('Hubo un error al eliminar el producto.');
            }
        });
    });
});
</script>
