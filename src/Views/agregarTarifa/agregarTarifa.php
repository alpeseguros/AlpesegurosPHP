<?php
// Archivo: tarifa.php
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php';


// Funciones para obtener los datos
function getCompanies($conn) {
    $query = "SELECT * FROM company";
    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}

function getAgeBrackets($conn) {
    $query = "SELECT * FROM agebracket";
    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}

function getTarifas($conn) {
    $query = "SELECT * FROM insurancepremium";
    $result = $conn->query($query);
    $tarifas = [];
    while ($row = $result->fetch_assoc()) {
        $tarifas[$row['age_bracket_id']][$row['company_id']] = $row;
    }
    return $tarifas;
}

// Manejo de formulario de agregar compañía
if (isset($_POST['newCompanyName'])) {
    $newCompanyName = $_POST['newCompanyName'];
    $conn->query("INSERT INTO company (name) VALUES ('$newCompanyName')");
    header("Location: agregarTarifa.php");
}

// Manejo de formulario de agregar rango de edad
if (isset($_POST['newAgeBracket'])) {
    $newAgeBracket = $_POST['newAgeBracket'];
    $conn->query("INSERT INTO agebracket (age) VALUES ('$newAgeBracket')");
    header("Location: agregarTarifa.php");
}

// Manejo de guardar o actualizar tarifa
if (isset($_POST['premium_amount'])) {
    $ageId = $_POST['age_bracket_id'];
    $companyId = $_POST['company_id'];
    $newPrice = $_POST['premium_amount'];

    $query = "SELECT * FROM insurancepremium WHERE age_bracket_id = $ageId AND company_id = $companyId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Actualizar tarifa existente
        $conn->query("UPDATE premium_insurance SET premium_amount = '$newPrice' WHERE age_bracket_id = $ageId AND company_id = $companyId");
    } else {
        // Insertar nueva tarifa
        $conn->query("INSERT INTO insurancepremium (age_bracket_id, company_id, premium_amount) VALUES ($ageId, $companyId, '$newPrice')");
    }

    header("Location: agregarTarifa.php");
}

// Manejo de eliminar compañía o rango de edad
if (isset($_GET['deleteCompanyId'])) {
    $companyId = $_GET['deleteCompanyId'];
    $conn->query("DELETE FROM company WHERE id = $companyId");
    $conn->query("DELETE FROM insurancepremium WHERE company_id = $companyId");
    header("Location: agregarTarifa.php");
}

if (isset($_GET['deleteAgeId'])) {
    $ageId = $_GET['deleteAgeId'];
    $conn->query("DELETE FROM agebracket WHERE id = $ageId");
    $conn->query("DELETE FROM insurancepremium WHERE age_bracket_id = $ageId");
    header("Location: agregarTarifa.php");
}

// Obtener datos para mostrar en la tabla
$companies = getCompanies($conn);
$ageBrackets = getAgeBrackets($conn);
$tarifas = getTarifas($conn);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de tarifas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php include '../../includes/header.php'; ?>
<h2>Gestión de Tarifas</h2>

<!-- Formulario para agregar nuevas compañías -->
<form method="POST">
    <label>Nombre de la nueva compañía:</label>
    <input type="text" name="newCompanyName" required>
    <button type="submit">Agregar Compañía</button>
</form>

<!-- Formulario para agregar nuevos rangos de edad -->
<form method="POST">
    <label>Nuevo Rango de Edad:</label>
    <input type="text" name="newAgeBracket" required>
    <button type="submit">Agregar Rango</button>
</form>

<h2>Tabla de Tarifas</h2>
<table border="1">
    <thead>
        <tr>
            <th>Rango de Edad</th>
            <?php foreach ($companies as $company): ?>
                <th>
                    <?php echo $company['name']; ?>
                    <a href="?deleteCompanyId=<?php echo $company['id']; ?>">Eliminar</a>
                </th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ageBrackets as $bracket): ?>
            <tr>
                <td><?php echo $bracket['age']; ?></td>
                <?php foreach ($companies as $company): ?>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="age_bracket_id" value="<?php echo $bracket['id']; ?>">
                            <input type="hidden" name="company_id" value="<?php echo $company['id']; ?>">
                            <input type="text" name="premium_amount" value="<?php echo isset($tarifas[$bracket['id']][$company['id']]) ? $tarifas[$bracket['id']][$company['id']]['premium_amount'] : ''; ?>" step="0.01">
                            <button type="submit">Guardar</button>
                        </form>
                    </td>
                <?php endforeach; ?>
                <td><a href="?deleteAgeId=<?php echo $bracket['id']; ?>">Eliminar Rango</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
<?php include '../../includes/footer.php'; ?>
</html>
