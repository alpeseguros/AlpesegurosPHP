<?php
// Iniciar la sesión con configuraciones de seguridad
session_start(
   );

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Regenerar el ID de sesión para prevenir fijación de sesión
session_regenerate_id(true);

// Conectar a la base de datos
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php';

// Obtener datos del usuario
$user_id = $_SESSION['user_id'];
$sql = "SELECT nombre FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../../includes/header.php'; ?>

    <div class="container mt-5">
        <h2>Bienvenido, <?php echo htmlspecialchars($username); ?></h2>
        <p>Este es tu perfil.</p>
        <!-- Agrega aquí más contenido relacionado con el perfil del usuario -->
    </div>

    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
