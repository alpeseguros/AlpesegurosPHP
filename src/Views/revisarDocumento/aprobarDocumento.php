<?php
// Incluir la conexión a la base de datos
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php'; 
require_once 'C:/xampp/htdocs/AlpeSegurosDev/vendor/autoload.php';

// Usar las clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use setasign\Fpdi\Fpdi; // Asegúrate de usar FPDI para poder importar archivos PDF

// Función para agregar la firma al PDF
function addSignatureToPDF($pdfFile, $signatureImage, $outputFile) {
    $pdf = new Fpdi();  // Usar FPDI en lugar de FPDF directamente
    $pdf->AddPage();
    
    // Importar el primer página del PDF original
    $pdf->setSourceFile($pdfFile); // Esto es posible porque estamos usando FPDI
    $tplIdx = $pdf->importPage(1); // Importar la primera página del archivo PDF
    $pdf->useTemplate($tplIdx);
    
    // Añadir la imagen de la firma
    $pdf->Image($signatureImage, 10, 150, 50);  // Ajusta la posición y tamaño de la firma

    // Añadir el texto "Firma: ______________"
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetXY(60, 150);  // Posiciona el texto cerca de la firma
    $pdf->Cell(100, 10, 'Firma: ________________', 0, 1);

    // Guardar el nuevo archivo PDF con la firma añadida
    $pdf->Output('F', $outputFile);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $documentoId = $_POST['documento_id'];
    echo $documentoId;

    // Actualizar el estado de aprobado en la base de datos
    $query = 'UPDATE pdfDocument SET aprobado = 1 WHERE uuid_pdf = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $documentoId);
    $stmt->execute();

    // Obtener el documento y el cliente asociado
    $queryDocumento = 'SELECT * FROM pdfDocument WHERE uuid_pdf = ?';
    $stmtDocumento = $conn->prepare($queryDocumento);
    $stmtDocumento->bind_param('i', $documentoId);
    $stmtDocumento->execute();
    $documento = $stmtDocumento->get_result()->fetch_assoc();

    // Verificar si el documento fue encontrado
    if (!$documento) {
        echo "Documento no encontrado.";
        exit;
    }

    // Configurar el correo con PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Configuración de correo
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'djangopruebas61@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'swwi vbbk ndfq pdst'; // Tu contraseña o App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configurar el remitente y destinatario
        $mail->setFrom('djangopruebas61@gmail.com', 'Generador de PDFs');
        $mail->addAddress($documento['email_cliente'], $documento['nombre_cliente']);
        $mail->Subject = 'Firma Aprobada';

        // Cuerpo del mensaje
        $mail->Body = "Estimado cliente,\n\nSu firma ha sido aprobada. Puede descargar el documento aprobado desde el siguiente enlace.\n\nArchivo: " . $documento['nombre_pdf'] . "\n\nSaludos,\nEquipo de Desarrollo";

        // Carpeta donde se encuentran los documentos
        $folderPath = 'C:\\xampp\\htdocs\\AlpeSegurosDev\\src\\Controllers\\pdfs\\' .  $documentoId;

        // Obtener todos los archivos en la carpeta
        $files = scandir($folderPath);

        // Agregar todos los archivos a adjuntar
        foreach ($files as $file) {
            // Verificar si el archivo es PDF o la firma
            if (strpos($file, '.pdf') !== false) {
                // Construir el nombre del archivo PDF a adjuntar
                $nombrePdf = 'documento-' .  $documentoId . '.pdf';
                $rutaPdf = $folderPath . '\\' . $file;

                // Verificar si el archivo es el documento que necesita la firma
                if (strpos($file, $nombrePdf) !== false) {
                    // Ruta de la firma
                    $firmaFile = 'firma-documento-' . $documentoId . '.png';
                    $rutaFirma = $folderPath . '\\' . $firmaFile;

                    // Verificar si la firma existe
                    if (file_exists($rutaFirma)) {
                        // Crear un nuevo PDF con la firma añadida
                        $outputPdf = $folderPath . '\\' . 'documento-con-firma-' . $documentoId . '.pdf';
                        addSignatureToPDF($rutaPdf, $rutaFirma, $outputPdf);
                        $rutaPdf = $outputPdf; // Usar el nuevo PDF con la firma añadida
                    } else {
                        echo "La firma no se encuentra para este documento.";
                    }
                }

                // Adjuntar el archivo PDF
                $mail->addAttachment($rutaPdf, 'Documento Aprobado - ' . $file);
            }
        }

        // Enviar el correo
        $mail->send();
        echo "Documento aprobado y correo enviado.";
        header("Location: /AlpeSegurosDev/src/Views/revisarDocumento/revisarDocumento.php"); // Redirigir a una página protegida
    } catch (Exception $e) {
        echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
}
?>
