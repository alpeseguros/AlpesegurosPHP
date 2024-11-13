<?php
session_start();
// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no está logueado, redirigir a la página de login
    header("Location: /Project/src/Views/user/login.php");
    exit();
}

// Si el usuario está logueado, prellenar los campos con la información del usuario
$nombre_apellido = '';
$telefono = '';
$correo = '';
$direccion = '';
$producto = isset($_GET['producto']) ? htmlspecialchars($_GET['producto']) : ''; 
$precio=isset($_GET['precio']) ? htmlspecialchars($_GET['precio']) : '';

if (isset($_SESSION['user_id'])) {
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
    $conn->close();

    $nombre_apellido = $nombre;
    $correo = $correo;
} else {
    // Campos vacíos para invitados
    $nombre_apellido = '';
    $telefono = '';
    $correo = '';
    $direccion = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    
</head>
<?php include '../../includes/header.php'; ?>
<body>
    

<div class="container mt-4">
        <h3>Diligencia el formulario de compra</h3>
        <form action="/Project/src/Controllers/enviar_pedido.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombres y Apellidos</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($nombre_apellido); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono/Celular</label>
                <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($telefono); ?>" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" name="correo" class="form-control" value="<?php echo htmlspecialchars($correo); ?>" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="<?php echo htmlspecialchars($direccion); ?>" required>
            </div>
            <div class="mb-3">
                <label for="producto" class="form-label">Producto</label>
                <input type="text" name="producto" class="form-control" value="<?php echo htmlspecialchars($producto); ?>" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" name="cantidad" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" name="precio" class="form-control" value="<?php echo htmlspecialchars($precio); ?>" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Enviar compra</button>
        </form>
    </div>

    <?php include '../../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
