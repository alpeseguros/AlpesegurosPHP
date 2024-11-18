<?php
include '../../includes/header.php'; 
require 'C:\xampp\htdocs\Project\src\Controllers\conexion.php'; // Asegúrate de incluir la conexión a la base de datos.

if (!isset($_SESSION['user_id'])) {
    header("Location: /AlpeSegurosDev/src/Views/user/login.php");
    exit();
}

// Generar un UUID único para el formulario
$uuid_formulario = uniqid('form_', true);
// Obtener los formularios existentes
$query = "SELECT uuid_formulario, nombre_formulario FROM formularios GROUP BY uuid_formulario, nombre_formulario";
$result = $conn->query($query);
$formularios = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $formularios[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear formato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="margin-top: 130px; margin-bottom: 80px;">

    <form action="/AlpeSegurosDev/src/Controllers/PDFGenerator.php" method="POST" enctype="multipart/form-data">
        <h2>Formulario Personalizado</h2>
          <!-- Botón y lista desplegable -->
        <div>
            <label for="formSelector">Seleccionar un formulario existente:</label>
            <select id="formSelector" onchange="loadSelectedForm()">
                <option value="">-- Seleccionar --</option>
                <?php foreach ($formularios as $formulario): ?>
                    <option value="<?php echo $formulario['uuid_formulario']; ?>">
                        <?php echo htmlspecialchars($formulario['nombre_formulario']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Campos base -->
        <label>
            Nombre:
            <input type="text" name="nombre" required>
        </label>
        <label>
            Teléfono:
            <input type="tel" name="telefono" required>
        </label>
        <label>
            E-mail:
            <input type="email" name="email" required>
        </label>

        <!-- Campos adicionales -->
        <div id="extraFieldsContainer">
            <label>Campos Adicionales:</label>
            <button type="button" onclick="addExtraField()">Agregar campo</button>
        </div>

        <!-- Campo de carga de archivos -->
        <label>
            Archivos:
            <input type="file" name="files[]" multiple>
        </label>
        <label>
           Nombre formulario:
            <input type="text" name="name_form">
        </label>
        <input type="hidden" name="uuid_formulario" value="<?php echo $uuid_formulario; ?>" />
        
        <button type="button" onclick="guardarFormulario()">Guardar Formulario</button>
        <button type="submit" name="submitPDF">Generar PDF</button>
    </form>

    <script>
        async function guardarFormulario() {
        const uuid = document.querySelector('input[name="uuid_formulario"]').value;
        const nombreFormulario = document.querySelector('input[name="name_form"]').value;
        const extraFieldNames = Array.from(document.querySelectorAll('input[name="extraFieldNames[]"]')).map(input => input.value);

        if (!nombreFormulario.trim()) {
            alert("El nombre del formulario es obligatorio para guardar.");
            return;
        }

        if (extraFieldNames.length === 0 || extraFieldNames.some(name => !name.trim())) {
            alert("Debes agregar al menos un campo adicional y asegurarte de que no estén vacíos.");
            return;
        }

        try {
            const response = await fetch('/AlpeSegurosDev/src/Controllers/guardar_formulario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ uuid, nombreFormulario, extraFieldNames })
            });

            const result = await response.json();
            if (result.success) {
                alert("Formulario guardado exitosamente.");
                window.location.href = '/AlpeSegurosDev/src/Views/crearFormato/crearFormato.php'
            } else {
                alert("Ocurrió un error al guardar el formulario.");
            }
        } catch (error) {
            console.error("Error al guardar el formulario:", error);
            alert("No se pudo guardar el formulario. Inténtalo de nuevo más tarde.");
        }
    }

        function addExtraField() {
            const container = document.getElementById("extraFieldsContainer");
            const div = document.createElement("div");
            div.innerHTML = `
                <input type="text" name="extraFieldNames[]" placeholder="Nombre del campo" required>
                <input type="text" name="extraFieldValues[]" placeholder="Valor del campo" required>
                <button type="button" onclick="this.parentElement.remove()">Eliminar campo</button>
            `;
            container.appendChild(div);
        }
        // Cargar datos del formulario seleccionado
        async function loadSelectedForm() {
                    const uuid = document.getElementById('formSelector').value;
                    if (!uuid) return;
                    
                    const response = await fetch(`/AlpeSegurosDev/src/Controllers/getFormDetails.php?uuid=${uuid}`);
                    console.log(response);

                    const data = await response.json();

                    
                    // Limpiar campos adicionales
                    const container = document.getElementById("extraFieldsContainer");
                    container.innerHTML = `<label>Campos Adicionales:</label>`;

                    // Agregar campos adicionales
                    data.extraFields.forEach(field => {
                        const div = document.createElement("div");
                        div.innerHTML = `
                            <input type="text" name="extraFieldNames[]" value="${field}" placeholder="Nombre del campo" required>
                            <input type="text" name="extraFieldValues[]" value="" placeholder="Valor del campo" required>
                            <button type="button" onclick="this.parentElement.remove()">Eliminar campo</button>
                        `;
                        container.appendChild(div);
                    });
                }

    </script>
</body>
</html>
