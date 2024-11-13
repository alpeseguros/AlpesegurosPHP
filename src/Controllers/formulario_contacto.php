<?php
// Conectar a la base de datos
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php'; // Asegúrate de que la ruta a tu archivo de conexión sea correcta

// Verificar que se enviaron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $comentarios = $_POST['comentarios'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO contactos (nombre_completo, telefono, correo, comentarios) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $telefono, $correo, $comentarios);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Cerrar la conexión
        $stmt->close();
        $conn->close();

        // Redirigir a la página de inicio después de guardar los datos
        header("Location: /Project/index.php");
        exit(); // Asegúrate de que el script se detenga después de la redirección
    } else {
        echo "Error al guardar los datos: " . $stmt->error;
    }
} else {
    echo "No se enviaron datos del formulario.";
}
?>
