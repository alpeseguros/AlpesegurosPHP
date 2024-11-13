<?php
// Iniciar la sesión y conectar a la base de datos

include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php';

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $animal = htmlspecialchars($_POST['animal']);
    $nombre_cuido = htmlspecialchars($_POST['nombre_cuido']);
    $precio = htmlspecialchars($_POST['precio']);
    $disponible = isset($_POST['disponible']) ? 1 : 0; // Checkbox, 1 si está marcado, 0 si no lo está

    // Preparar la consulta de inserción
    $sql = "INSERT INTO cuido_db (descripcion, animal, nombre_cuido, disponible,precio) VALUES (?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind de los parámetros
        $stmt->bind_param("sssid", $descripcion, $animal, $nombre_cuido, $disponible,$precio);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $success = "Producto agregado correctamente.";
        } else {
            $error = "Error al agregar el producto: " . $conn->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        $error = "Error al preparar la consulta: " . $conn->error;
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
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="margin-top: 130px; margin-bottom: 80px;">
<?php include '../../includes/header.php'; ?>
    
    <div class="container mt-5">
        <h2>Agregar Producto</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="mb-3">
                <label for="animal" class="form-label">Animal</label>
                <input type="text" class="form-control" id="animal" name="animal" required>
            </div>
            <div class="mb-3">
                <label for="disponible" class="form-label">Disponible</label>
                <input type="checkbox" class="form-check-input" id="disponible" name="disponible" checked>
                <label class="form-check-label" for="disponible">Disponible para venta</label>
            </div>
            <div class="mb-3">
                <label for="nombre_cuido" class="form-label">Nombre del Cuido</label>
                <input type="text" class="form-control" id="nombre_cuido" name="nombre_cuido" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Producto</button>
        </form>
    </div>


    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
