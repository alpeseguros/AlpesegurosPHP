<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';
    $provincia = $_POST['provincia'] ?? '';
    $aceptaProteccionDatos = isset($_POST['aceptaProteccionDatos']) ? 1 : 0;
    $deseaPromociones = $_POST['deseaPromociones'] ?? '';

    // Procesar las edades ingresadas
    $edades = isset($_POST['edades']) ? $_POST['edades'] : [];
    $uniqueId = uniqid(); // Generar un ID único para la sesión

    // Simular envío de datos de cada edad
    foreach ($edades as $edad) {
        $edad = intval($edad); // Asegurar que sea un número

        // Aquí podrías hacer la inserción en la base de datos o enviar los datos a una API
        // Ejemplo: guardar en la base de datos
        // $stmt = $db->prepare("INSERT INTO seguros (nombre, telefono, email, provincia, edad, aceptaProteccionDatos, deseaPromociones) VALUES (?, ?, ?, ?, ?, ?, ?)");
        // $stmt->bind_param('ssssiii', $uniqueId, $telefono, $email, $provincia, $edad, $aceptaProteccionDatos, $deseaPromociones);
        // $stmt->execute();
    }

    // Redirigir después de procesar el formulario
    header("Location: resultado-consulta.php?nombre=" . $uniqueId);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular seguro de salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="margin-top: 130px; margin-bottom: 80px;">

<?php include '../../includes/header.php'; ?>


<form method="POST" action="" style="width: 300px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9;">
    <h2 style="text-align: center;">Calcular Seguro de Salud</h2>
    <label>Teléfono:
        <input type="tel" name="telefono" required class="form-control mb-3" />
    </label>
    <label>E-mail:
        <input type="email" name="email" required class="form-control mb-3" />
    </label>
    <label>Provincia:
        <select name="provincia" required class="form-control mb-3">
            <option value="">Seleccionar Provincia</option>
            <option value="Provincia 1">Provincia 1</option>
            <option value="Provincia 2">Provincia 2</option>
        </select>
    </label>
    <label>¿A quién vas a asegurar? Edad:
        <input type="number" name="currentEdad" class="form-control mb-3" />
        <button type="button" onclick="addEdad()">Agregar Edad</button>
    </label>
    <ul id="edadesList"></ul>

    <input type="hidden" name="edades[]" id="edadesInput" />

    <label><input type="checkbox" name="aceptaProteccionDatos" required /> Acepto la información básica sobre protección de datos</label>
    <br>
    <label>¿Desea estar informado sobre ofertas y promociones de seguros?</label>
    <br>
    <input type="radio" name="deseaPromociones" value="1" /> Sí
    <input type="radio" name="deseaPromociones" value="0" /> No

    <button type="submit" class="btn btn-primary mt-3">Calcular seguro</button>
</form>

<script>
    const edades = [];

    function addEdad() {
        const edadInput = document.querySelector('input[name="currentEdad"]');
        const edad = edadInput.value;
        if (edad) {
            edades.push(edad);
            updateEdadesList();
            edadInput.value = '';
        }
    }

    function updateEdadesList() {
        const edadesList = document.getElementById('edadesList');
        edadesList.innerHTML = '';
        edades.forEach((edad, index) => {
            const listItem = document.createElement('li');
            listItem.textContent = `Edad: ${edad}`;
            edadesList.appendChild(listItem);
        });
        document.getElementById('edadesInput').value = JSON.stringify(edades);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php include '../../includes/footer.php'; ?>
</html>
