<?php
// pdf.php


include_once 'C:\xampp\htdocs\Project\src\Controllers\conexion.php'; // Suponemos que tienes una clase para conectarte a la base de datos

// Obtener el PDF por UUID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['uuid_pdf'])) {
    $uuid_pdf = $_GET['uuid_pdf'];
    
    // Consulta SQL para obtener el valor de 'firmado' desde la tabla 'pdfdocument'
    $sql = "SELECT firmado FROM pdfdocument WHERE uuid_pdf = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uuid_pdf); // Vincula el parámetro para la consulta
    $stmt->execute();
    $stmt->bind_result($firmado); // Obtiene el valor de 'firmado'

    // Ejecutar la consulta
    if ($stmt->fetch()) {
        // Si la consulta tiene un resultado, obtén el valor de 'firmado'
        $firmado = (int) $firmado; // Asegúrate de que 'firmado' sea un valor numérico (1 o 0)
    } else {
        // Si no se encuentra el UUID en la base de datos, asigna un valor predeterminado
        $firmado = 0;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();







    $documentRoot = $_SERVER['DOCUMENT_ROOT'];
    $folderPath = $documentRoot . "/AlpeSegurosDev/src/Controllers/pdfs/$uuid_pdf";
    $filePath = "$folderPath/documento-$uuid_pdf.pdf";
    
    if (file_exists($filePath)) {
        // Codificar el archivo PDF a base64
        $pdfBase64 = base64_encode(file_get_contents($filePath));

        // Obtener el nombre del archivo sin ruta
        $fileName = basename($filePath);
      

        // Responder con los detalles del PDF
        echo json_encode([
            'nombre_pdf' => $fileName,
            'pdf_base64' => $pdfBase64,
            'firmado' => $firmado,
        ]);
    } else {
        // Archivo no encontrado
        echo json_encode(['error' => 'PDF no encontrado']);
    }
}

// Actualizar el estado de firmado
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['uuid_pdf'])) {
    $uuid_pdf = $_GET['uuid_pdf'];
    
    // Actualizar el estado de firmado
    $query = "UPDATE pdfdocument SET firmado = 1 WHERE uuid_pdf = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$uuid_pdf]);
    
    if ($stmt->rowCount()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}

// Guardar firma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['uuid_pdf'])) {
    $uuid_pdf = $_GET['uuid_pdf'];
    
    // Leer el JSON de php://input
    $data = json_decode(file_get_contents('php://input'), true);

    $firma_base64 = $data["firma"];
    $documentRoot = $_SERVER['DOCUMENT_ROOT'];
    $folderPath = $documentRoot . "/AlpeSegurosDev/src/Controllers/pdfs/$uuid_pdf";
    $imagen_ruta = "$folderPath/firma-documento-{$uuid_pdf}.png";
    

    // Guardar la imagen base64 como archivo
    file_put_contents($imagen_ruta, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $firma_base64)));

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Insertar la firma en la tabla 'firma'
        $query = "INSERT INTO firma (uuid_firma, ip, hora, fecha_firmado, pdf_documento, imagen_firma) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$uuid_pdf, $data["ip"], date('H:i:s'), date('Y-m-d'), $uuid_pdf, $imagen_ruta]);

        // Actualizar el estado de firmado en la tabla 'pdfdocument'
        $query = "UPDATE pdfdocument SET firmado = 1 WHERE uuid_pdf = ?";
        $stmt = $conn->prepare($query);

        // Vincular el parámetro para evitar inyecciones de SQL
        $stmt->bind_param("s", $uuid_pdf); // 's' indica que el parámetro es una cadena
        $stmt->execute();

        // Si ambas operaciones son exitosas, hacer commit
        $conn->commit();
        
        echo json_encode(['status' => 'success']);

    } catch (Exception $e) {
        // Si ocurre algún error, hacer rollback
        $conn->rollback();
        
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

