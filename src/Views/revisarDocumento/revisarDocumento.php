<?php
// DocumentosConFirmas.php
include '../../includes/header.php';
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php'; // Conexión a la base de datos

// Obtener documentos desde la tabla pdfDocument
$queryDocumentos = 'SELECT * FROM pdfDocument';
$stmtDocumentos = $conn->prepare($queryDocumentos);
$stmtDocumentos->execute();
$resultDocumentos = $stmtDocumentos->get_result();
$documentos = array();

// Almacenar todos los documentos en un array
while ($row = $resultDocumentos->fetch_assoc()) {
    $documentos[] = $row;
}

// Obtener firmas desde la tabla firma
$queryFirmas = 'SELECT * FROM firma';
$stmtFirmas = $conn->prepare($queryFirmas);
$stmtFirmas->execute();
$resultFirmas = $stmtFirmas->get_result();
$firmas = array();

// Almacenar todas las firmas en un array
while ($row = $resultFirmas->fetch_assoc()) {
    $firmas[] = $row;
}

// Función para asociar la firma a cada documento
function asociarFirma($documentoId, $firmas) {
    foreach ($firmas as $firma) {
        if ($firma['pdf_documento'] == $documentoId) {
            return $firma['uuid_firma']; // Cambiar 'uuid_firma' por el campo adecuado de tu tabla de firmas
        }
    }
    return 'No disponible';
}

// Función para enviar correo con los documentos
function enviarCorreo($email, $documentoPath, $archivosExtras) {
    $subject = "Su firma ha sido aprobada";
    $message = "Estimado cliente,\n\nSu firma ha sido aprobada. Por favor, encuentre adjuntos los documentos correspondientes.";
    $headers = "From: no-reply@example.com";

    // Archivos adjuntos
    $attachments = array_merge([$documentoPath], $archivosExtras);

    // Implementar envío con PHPMailer o similar (para correos con archivos)
    // Aquí se incluiría el código detallado para adjuntar y enviar los correos.

    return mail($email, $subject, $message, $headers);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos y Firmas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Documentos y Firmas</h2>

    <table class="table">
    <thead>
        <tr>
            <th>UUID PDF</th>
            <th>Nombre Cliente</th>
            <th>Email Cliente</th>
            <th>Nombre PDF</th>
            <th>Firmado</th>
            <th>Aprobado</th>
            <th>Fecha Creación</th>
            <th>Firma Asociada</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($documentos as $documento): ?>
            <tr>
                <td><?= $documento['uuid_pdf']; ?></td>
                <td><?= $documento['nombre_cliente']; ?></td>
                <td><?= $documento['email_cliente']; ?></td>
                <td><?= $documento['nombre_pdf']; ?></td>
                <td><?= $documento['firmado'] ? 'Sí' : 'No'; ?></td>
                <td><?= $documento['aprobado'] ? 'Sí' : 'No'; ?></td>
                <td><?= $documento['fecha_creacion']; ?></td>
                <td><?= asociarFirma($documento['uuid_pdf'], $firmas); ?></td>
                <td>
                    
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalRevisar<?= $documento['uuid_pdf']; ?>" <?= $documento['aprobado'] ? 'disabled' : ''; ?>>
                        Aprobar
                    </button>
                </td>
            </tr>
            
        <?php endforeach; ?>
    </tbody>
</table>


    <!-- Modal para revisar documento -->
     <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS (incluye Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php foreach ($documentos as $documento): ?>
        <div class="modal fade" id="modalRevisar<?= $documento['uuid_pdf']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalRevisarLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRevisarLabel">Revisar Documento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Detalles del Documento</h5>
                        <p><strong>UUID PDF:</strong> <?= $documento['uuid_pdf']; ?></p>
                        <p><strong>Cliente:</strong> <?= $documento['nombre_cliente']; ?></p>
                        <p><strong>Email:</strong> <?= $documento['email_cliente']; ?></p>
                        <p><strong>PDF:</strong> <?= $documento['nombre_pdf']; ?></p>
                        <p><strong>Firmado:</strong> <?= $documento['firmado'] ? 'Sí' : 'No'; ?></p>
                        <p><strong>Aprobado:</strong> <?= $documento['aprobado'] ? 'Sí' : 'No'; ?></p>
                        <p><strong>Fecha de Creación:</strong> <?= $documento['fecha_creacion']; ?></p>
                    </div>
                    <div class="modal-footer">
                        <form action="aprobarDocumento.php" method="post">
                            <input type="hidden" name="documento_id" value="<?= $documento['uuid_pdf']; ?>">
                            <button type="submit" class="btn btn-primary">Aprobar</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include '../../includes/footer.php'; ?>
</body>
</html>
