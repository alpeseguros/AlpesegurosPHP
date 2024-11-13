<?php
session_start();

// Verificar si el carrito está en la sesión, de lo contrario, inicializarlo como un arreglo vacío
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Función para calcular el total del carrito
function calcularTotal($carrito) {
    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['cantidad'] * $item['precio'];
    }
    return $total;
}

// Procesar la eliminación de un producto del carrito
if (isset($_GET['eliminar'])) {
    $productoId = $_GET['eliminar'];
    foreach ($_SESSION['carrito'] as $index => $item) {
        if ($item['id'] == $productoId) {
            unset($_SESSION['carrito'][$index]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
            break;
        }
    }
}

// Procesar la actualización de cantidad
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['cantidad'] as $productoId => $cantidad) {
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id'] == $productoId) {
                $item['cantidad'] = max(1, (int)$cantidad); // Asegurar que la cantidad sea al menos 1
                break;
            }
        }
    }
}

// Obtener el carrito actualizado de la sesión
$carrito = $_SESSION['carrito'];
$total = calcularTotal($carrito);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Carrito de Compras</h1>
        <?php if (count($carrito) > 0): ?>
            <form method="POST" action="carrito.php">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carrito as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                                <td><?php echo number_format($item['precio'], 2); ?> $</td>
                                <td>
                                    <input type="number" name="cantidad[<?php echo $item['id']; ?>]" 
                                           value="<?php echo $item['cantidad']; ?>" min="1" class="form-control">
                                </td>
                                <td><?php echo number_format($item['cantidad'] * $item['precio'], 2); ?> $</td>
                                <td>
                                    <a href="carrito.php?eliminar=<?php echo $item['id']; ?>" class="btn btn-danger">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                            <td colspan="2"><?php echo number_format($total, 2); ?> $</td>
                        </tr>
                    </tfoot>
                </table>
                <button type="submit" class="btn btn-primary">Actualizar Carrito</button>
                <a href="checkout.php" class="btn btn-success">Finalizar Compra</a>
            </form>
        <?php else: ?>
            <p>Tu carrito está vacío.</p>
            <a href="consulta.php" class="btn btn-primary">Ver productos</a>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
