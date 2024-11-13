<?php
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Conectar a la base de datos
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php';

try {
    // Obtener el ID del usuario desde la sesión
    $user_id = $_SESSION['user_id'];

    // Consulta para actualizar el campo 'pagado' a 0 para todos los productos en el carrito del usuario
    $sqlCarrito = "UPDATE carrito_compras 
                   SET pagado = 0 
                   WHERE usuario = (SELECT nombre FROM usuarios WHERE id = ?) AND pagado = 1 AND in_cart = 1";
    
    $stmtCarrito = $conn->prepare($sqlCarrito);
    $stmtCarrito->bind_param("i", $user_id);

    // Ejecutar la consulta en carrito_compras y verificar si se ha actualizado al menos un registro
    if ($stmtCarrito->execute()) {
        if ($stmtCarrito->affected_rows > 0) {
            // Ahora actualizar la tabla 'compras'
            $sqlCompras = "UPDATE compras 
                           SET pagado = 0 
                           WHERE nombre = (SELECT nombre FROM usuarios WHERE id = ?) AND pagado = 1";
            
            $stmtCompras = $conn->prepare($sqlCompras);
            $stmtCompras->bind_param("i", $user_id);

            if ($stmtCompras->execute()) {
                if ($stmtCompras->affected_rows > 0) {
                    // Redirigir a una página de confirmación de compra o mostrar un mensaje de éxito
                    echo "<script>alert('Compra finalizada con éxito en ambas tablas.'); window.location.href='confirmacion_compra.php';</script>";
                } else {
                    echo "<script>alert('No se encontraron productos en la tabla compras para finalizar.'); window.location.href='carrito.php';</script>";
                }
            } else {
                throw new Exception("Error al actualizar los registros en la tabla compras: " . $stmtCompras->error);
            }

            $stmtCompras->close();
        } else {
            echo "<script>alert('No se encontraron productos en el carrito para finalizar.'); window.location.href='carrito.php';</script>";
        }
    } else {
        throw new Exception("Error al actualizar los registros en la tabla carrito_compras: " . $stmtCarrito->error);
    }

    $stmtCarrito->close();
    $conn->close();
} catch (Exception $e) {
    echo "Ocurrió un error: " . $e->getMessage();
    echo "<script>alert('Hubo un problema al finalizar la compra. Inténtalo de nuevo más tarde.'); window.location.href='carrito.php';</script>";
}
?>
