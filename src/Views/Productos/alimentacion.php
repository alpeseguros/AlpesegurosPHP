<?php
session_start();
// Conectar a la base de datos
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php';

// Consultar datos de la base de datos
$sql = "SELECT nombre_cuido, descripcion, animal, disponible, foto_producto,precio FROM cuido_db WHERE disponible = 1";
$result = $conn->query($sql);

// Crear un arreglo para almacenar los datos
$alimentacion = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $alimentacion[$row['animal']][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alimentación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include '../../includes/header.php'; ?>

    <div class="container" style="margin-top: 130px;margin-bottom: 80px">
        <?php foreach ($alimentacion as $animal => $productos): ?>
            <h3>Alimentación para <?php echo htmlspecialchars($animal); ?></h3>
            <div class="row row-cols-3 ">
                <?php foreach ($productos as $producto): ?>
                    <div class="col">
                        <div class="card">
                            <!-- Asegúrate de que 'foto_producto' contiene una ruta válida -->
                            <img src="<?php echo htmlspecialchars($producto['foto_producto']); ?>" class="card-img-top" alt="Imagen de <?php echo htmlspecialchars($producto['nombre_cuido']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre_cuido']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                                <p class="card-text"><?php echo htmlspecialchars($producto['precio']); ?></p>
                                <h5 class="card-title">Nosotros solo somos asesores no vendedores</h5>
                                <a href="/Project/src/Views/compra/comprar.php?producto=<?php echo urlencode($producto['nombre_cuido']); ?>&precio=<?php echo urlencode($producto['precio']); ?>" class="btn btn-primary">Comprar</a>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
