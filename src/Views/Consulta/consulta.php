<?php
session_start();
// Conectar a la base de datos
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php';

// Variables de filtro
$nombre_cuido = isset($_GET['nombre_cuido']) ? $_GET['nombre_cuido'] : '';
$animal = isset($_GET['animal']) ? $_GET['animal'] : '';
$disponible = isset($_GET['disponible']) ? $_GET['disponible'] : '';

// Construir la consulta SQL con filtros
$sql = "SELECT * FROM cuido_db WHERE 1";

if (!empty($nombre_cuido)) {
    $sql .= " AND nombre_cuido LIKE '%" . $conn->real_escape_string($nombre_cuido) . "%'";
}
if (!empty($animal)) {
    $sql .= " AND animal = '" . $conn->real_escape_string($animal) . "'";
}
if ($disponible !== '') {
    $sql .= " AND disponible = '" . $conn->real_escape_string($disponible) . "'";
}

$result = $conn->query($sql);

// Comprobar si la consulta devuelve resultados
if ($result->num_rows > 0) {
    $cuidoData = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $cuidoData = [];
}

// Consulta para obtener todos los animales disponibles para el filtro
$animalQuery = "SELECT DISTINCT animal FROM cuido_db";
$animalsResult = $conn->query($animalQuery);
$animals = [];
if ($animalsResult->num_rows > 0) {
    while ($row = $animalsResult->fetch_assoc()) {
        $animals[] = $row['animal'];
    }
}

// Aquí no debes cerrar la conexión todavía
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información Cuido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="margin: 0; padding: 0;">

    <?php include '../../includes/header.php'; ?>

    <div class="container mt-4">
        <h2>Información de la Tabla Cuido</h2>

        <!-- Formulario de Filtro -->
        <form action="consulta.php" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="nombre_cuido" class="form-label">Nombre Cuido</label>
                    <input type="text" name="nombre_cuido" id="nombre_cuido" class="form-control" value="<?php echo htmlspecialchars($nombre_cuido); ?>" placeholder="Filtrar por nombre">
                </div>
                <div class="col-md-4">
                    <label for="animal" class="form-label">Animal</label>
                    <select name="animal" id="animal" class="form-control">
                        <option value="">Seleccionar Animal</option>
                        <?php foreach ($animals as $animalOption): ?>
                            <option value="<?php echo htmlspecialchars($animalOption); ?>" <?php echo ($animal == $animalOption) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($animalOption); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="disponible" class="form-label">Disponible</label>
                    <select name="disponible" id="disponible" class="form-control">
                        <option value="">Seleccionar Disponibilidad</option>
                        <option value="1" <?php echo ($disponible == '1') ? 'selected' : ''; ?>>Disponible</option>
                        <option value="0" <?php echo ($disponible == '0') ? 'selected' : ''; ?>>No Disponible</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
        </form>

        <!-- Tabla de Datos -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Cuido</th>
                    <th>Descripción</th>
                    <th>Animal</th>
                    <th>Disponible</th>
                    <th>Foto Producto</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cuidoData)): ?>
                    <?php foreach ($cuidoData as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre_cuido']); ?></td>
                            <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($row['animal']); ?></td>
                            <td><?php echo htmlspecialchars($row['disponible']) == 1 ? 'Disponible' : 'No Disponible'; ?></td>
                            <td><img src="<?php echo htmlspecialchars($row['foto_producto']); ?>" alt="Foto de Producto" width="100"></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No hay datos disponibles para los filtros seleccionados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php $conn->close(); // Aquí cierras la conexión después de haber hecho todas las consultas. ?>
</body>
</html>

