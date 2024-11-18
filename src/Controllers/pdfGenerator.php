<?php
require 'fpdf.php';
require 'C:\xampp\htdocs\Project\src\Controllers\conexion.php'; // Asegúrate de incluir la conexión a la base de datos.

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Función para generar UUID
    function generateUUID() {
        return bin2hex(random_bytes(16));
    }

    $uuid = generateUUID();
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $extraFields = $_POST['extraFieldNames'] ?? [];
    $extraValues = $_POST['extraFieldValues'] ?? [];
    $fechaCreacion = date('Y-m-d H:i:s');
    $nombreFormulario= $_POST['name_form'];
    // Crear carpeta para el UUID
    $folderPath = __DIR__ . "/pdfs/$uuid";
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // Crear instancia de FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    
    // Agregar contenido al PDF
    $pdf->Cell(40, 10, "UUID PDF: $uuid");
    $pdf->Ln();
    $pdf->Cell(40, 10, "Nombre: $nombre");
    $pdf->Ln();
    $pdf->Cell(40, 10, "Teléfono: $telefono");
    $pdf->Ln();
    $pdf->Cell(40, 10, "Email: $email");
    $pdf->Ln();

    // Agregar campos adicionales
    for ($i = 0; $i < count($extraFields); $i++) {
        $pdf->Cell(40, 10, "{$extraFields[$i]}: {$extraValues[$i]}");
        $pdf->Ln();
    }

    // Guardar el PDF en la carpeta del UUID
    $pdfFileName = $folderPath . "/documento-$uuid.pdf";
    $pdf->Output('F', $pdfFileName);

    // Procesar y guardar los archivos subidos en la carpeta del UUID
    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['name'] as $key => $fileName) {
            $fileTmpPath = $_FILES['files']['tmp_name'][$key];
            $fileDestination = $folderPath . '/' . basename($fileName);
            move_uploaded_file($fileTmpPath, $fileDestination);
        }
    }

    // Guardar datos en la base de datos
    $query = "INSERT INTO pdfdocument (uuid_pdf, nombre_cliente, email_cliente, nombre_pdf, firmado, aprobado, fecha_creacion) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssss', $uuid, $nombre, $email, $pdfFileName, $firmado, $aprobado, $fechaCreacion);

    // Valores por defecto para firmado y aprobado
    $firmado = 'No'; 
    $aprobado = 'No';

    if ($stmt->execute()) {

     

        // Enviar correo
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'djangopruebas61@gmail.com'; // Tu correo de Gmail
            $mail->Password = 'swwi vbbk ndfq pdst'; // Tu contraseña o App Password de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
        
            // Configuración del correo
            $mail->setFrom('djangopruebas61@gmail.com', 'Generador de PDFs');
            $mail->addAddress($email, $nombre);
            $mail->Subject = 'Tu PDF generado';
            $mail->Body = "Hola $nombre,\n\nAquí tienes el PDF que solicitaste y los archivos que subiste.\n\nSaludos,\nEquipo de Desarrollo. aqui esta el link para que analices cada documento y firmes http://localhost/AlpeSegurosDev/src/Views/firmarDocumentos/firmarDocumentos.php?uuid_pdf=$uuid";
            
            // Adjuntar el PDF generado
            $mail->addAttachment($pdfFileName); 
        
            // Adjuntar archivos adicionales
            if (!empty($_FILES['files']['name'][0])) {
                foreach ($_FILES['files']['name'] as $key => $fileName) {
                    $fileTmpPath = $_FILES['files']['tmp_name'][$key];
                    $fileDestination = $folderPath . '/' . basename($fileName);
                    if (file_exists($fileDestination)) {
                        $mail->addAttachment($fileDestination, $fileName);
                    }
                }
            }
        
            // Enviar el correo
            $mail->send();
            echo "<script>alert('PDF generado, guardado y enviado correctamente con los archivos adjuntos.'); window.location.href='/AlpeSegurosDev/src/Views/crearFormato/crearFormato.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('PDF generado, pero no se pudo enviar el correo: {$mail->ErrorInfo}'); window.location.href='/AlpeSegurosDev/src/Views/crearFormato/crearFormato.php';</script>";
        }
        
    } else {
        echo "<script>alert('Error al guardar los datos en la base de datos.'); window.location.href='/AlpeSegurosDev/src/Views/crearFormato/crearFormato.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: /AlpeSegurosDev/src/Views/crearFormato/crearFormato.php");
    exit();
}
?>

