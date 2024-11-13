<?php
// Iniciar sesión y conectar a la base de datos
session_start();
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php';

// Obtener datos de la solicitud
$data = json_decode(file_get_contents("php://input"), true);
$itemId = $data['id'] ?? 0;

// Verificar que haya un usuario conectado y un itemId válido
if (isset($_SESSION['user_id']) && $itemId) {
    // Actualizar el estado del carrito en la base de datos
    $sql = "UPDATE carrito_compras SET in_cart = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();

    // Verificar si la actualización fue exitosa
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el estado del carrito.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Acceso no autorizado o ID de elemento no válido.']);
}

$conn->close();
?>
