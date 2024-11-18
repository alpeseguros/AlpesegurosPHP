<?php
require 'C:\xampp\htdocs\Project\src\Controllers\conexion.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $uuid = $data['uuid'] ?? null;
    $nombreFormulario = $data['nombreFormulario'] ?? null;
    $extraFields = $data['extraFieldNames'] ?? [];

    if (!$uuid || !$nombreFormulario || empty($extraFields)) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
        exit;
    }

    foreach ($extraFields as $fieldName) {
        $stmt = $conn->prepare("INSERT INTO formularios (uuid_formulario, nombre_formulario, campo_formulario) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $uuid, $nombreFormulario, $fieldName);
        $stmt->execute();
    }

    echo json_encode(['success' => true, 'message' => 'Formulario guardado correctamente.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
