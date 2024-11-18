<?php
require 'C:\xampp\htdocs\Project\src\Controllers\conexion.php';

if (isset($_GET['uuid'])) {
    $uuid = $_GET['uuid'];

    

    // Obtener campos adicionales
    $extraFields = [];
    $query = "SELECT campo_formulario FROM formularios WHERE uuid_formulario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $uuid);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $extraFields[] = $row['campo_formulario'];
    }

    echo json_encode([
        
        'extraFields' => $extraFields,
    ]);
}
?>
