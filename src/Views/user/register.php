<?php
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php'; // Ajusta la ruta según sea necesario

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar datos del formulario
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $tipo_cliente = isset($_POST['tipo_cliente']) ? $_POST['tipo_cliente'] : 0; // 0 para cliente, 1 para proveedor

    // Validación simple
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Todos los campos son requeridos.";
    } else {
        // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta SQL para insertar datos
        $sql = "INSERT INTO usuarios (nombre, correo, password, tipo_cliente) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssi", $username, $email, $hashed_password, $tipo_cliente);
            if ($stmt->execute()) {
                header("Location: login.php"); // Redirigir a la página de inicio de sesión después del registro
                exit();
            } else {
                $error = "Error al registrar el usuario: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Error en la consulta: " . $conn->error;
        }
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="margin-top: 130px;margin-bottom: 80px">
<?php include '../../includes/header.php'; ?>
    <div class="container mt-5">
        <h2>Registro</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="tipo_cliente" class="form-label">Tipo de Usuario</label>
                <select class="form-select" id="tipo_cliente" name="tipo_cliente" required>
                    <option value="0">Cliente</option>
                    <option value="1">Proveedor</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
    <?php include '../../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
