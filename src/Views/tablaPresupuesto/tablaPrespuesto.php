<?php


// Obtiene el parámetro 'nombre' desde la URL
$nombre = $_GET['nombre'] ?? '';

// Variables para almacenar los datos de la tabla
$filteredData = [];
$totalPrice = [];
$companyNames = [];

// Función para hacer la solicitud a la API y obtener datos
function fetchData($url) {
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Obtener datos de la API si 'nombre' está definido
if (!empty($nombre)) {
    $filteredData = fetchData("http://127.0.0.1:8000/api/save_health_insurance/?nombre=" . urlencode($nombre));

    // Filtrar datos por nombre
    $filteredData = array_filter($filteredData, function ($item) use ($nombre) {
        return $item['nombre'] === $nombre;
    });

    if (!empty($filteredData)) {
        // Obtener datos adicionales de la API
        $companies = fetchData("http://127.0.0.1:8000/api/companies/");
        $ageBrackets = fetchData("http://127.0.0.1:8000/api/age_brackets/");
        $prices = fetchData("http://127.0.0.1:8000/api/premium_insurance/");

        // Calcular el total de precios por compañía
        foreach ($filteredData as $item) {
            $ageBracket = current(array_filter($ageBrackets, function ($bracket) use ($item) {
                return $bracket['age'] === $item['edad'];
            }));

            if ($ageBracket) {
                foreach ($prices as $priceItem) {
                    if ($priceItem['age_bracket'] === $ageBracket['id']) {
                        $companyId = $priceItem['company'];
                        $premiumAmount = (float)$priceItem['premium_amount'];

                        if (isset($totalPrice[$companyId])) {
                            $totalPrice[$companyId] += $premiumAmount;
                        } else {
                            $totalPrice[$companyId] = $premiumAmount;
                            $companyNames[$companyId] = current(array_filter($companies, function ($company) use ($companyId) {
                                return $company['id'] === $companyId;
                            }))['name'] ?? "Desconocida";
                        }
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Precios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="tabla-precios-container">
<?php include '../../includes/header.php'; ?>

    <h2>Tabla de Precios</h2>
    <table class="tabla-precios">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Compañía</th>
                <th>Total Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($totalPrice)): ?>
                <?php foreach ($totalPrice as $companyId => $price): ?>
                    <tr>
                        <td><img src="<?php echo $companyNames[$companyId]; ?>.png" alt="Logo" class="company-logo" /></td>
                        <td><?php echo htmlspecialchars($companyNames[$companyId]); ?></td>
                        <td><?php echo number_format($price, 2); ?> €</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Cargando o no hay datos disponibles para el nombre especificado</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>

</body>
</html>
