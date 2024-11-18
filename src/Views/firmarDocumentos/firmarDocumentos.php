<?php
// index.php
include '../../includes/header.php'; 

// Suponiendo que el uuid_pdf es pasado como parámetro en la URL
$uuid_pdf = $_GET['uuid_pdf'] ?? null;

?>





<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin-top: 130px;
            margin-bottom: 80px;
        }

        #pdf-container {
            margin-bottom: 30px;
        }

        /* Modal */
        #signature-modal {
            display: none;
            position: fixed;
            top: 50px;
            left: 50%;
            transform: translate(-50%, 50%);
            width: 80%;
            height: 500px;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border: 2px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        /* Fondo del modal */
        .modal-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 10%;
            height: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        canvas {
            border: 1px solid #000;
        }
    </style>
</head>
<body>

<header>
    <h2>Visualización del PDF</h2>
</header>

<div id="pdf-container">
    <div id="pdf-info">
        <p id="pdf-name">Nombre del PDF: Cargando...</p>
    </div>
    <iframe id="pdf-viewer" src="" width="100%" height="600px"></iframe>
</div>

<button id="open-modal-btn" class="btn btn-primary">Firmar Documento</button>

<!-- Fondo del modal -->
<div class="modal-background" id="modal-background"></div>

<!-- Modal de firma -->
<div id="signature-modal" class="modal">
    <h3>Firma del Documento</h3>
    <canvas id="signature-canvas" width="400" height="200"></canvas>
    <div>
        <button id="save-signature-btn" class="btn btn-success">Guardar Firma</button>
        <button id="clear-signature-btn" class="btn btn-warning">Limpiar Firma</button>
        <button id="close-modal-btn" class="btn btn-danger">Cerrar</button>
    </div>
</div>

<footer>
    <p>&copy; 2024 Empresa</p>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    // Variables
    const pdfViewer = document.getElementById('pdf-viewer');
    const pdfNameElement = document.getElementById('pdf-name');
    const openModalBtn = document.getElementById('open-modal-btn');
    const signatureModal = document.getElementById('signature-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const saveSignatureBtn = document.getElementById('save-signature-btn');
    const clearSignatureBtn = document.getElementById('clear-signature-btn');
    const signatureCanvas = document.getElementById('signature-canvas');
    const modalBackground = document.getElementById('modal-background');
    const ctx = signatureCanvas.getContext('2d');
    const uuidPdf = "<?php echo $uuid_pdf; ?>"; // UUID del PDF

    let signatureImage = null;
    let userIp = '';
    let isDrawing = false;
    let lastX = 0;
    let lastY = 0;
    
    // Obtener los datos del PDF
    console.log(uuidPdf)
    axios.get(`pdf.php?uuid_pdf=${uuidPdf}`)
    .then(response => {
        console.log("Respuesta del PDF:", response.data)
        const data = response.data;
        console.log(data)
        if (data.firmado === 1) {
            window.location.href = '/AlpeSegurosDev';
        } else {
            
            if (data.pdf_base64) {
                // Cargar el PDF en el iframe
                pdfNameElement.textContent = `Nombre del PDF: ${data.nombre_pdf}`;
                pdfViewer.src = `data:application/pdf;base64,${data.pdf_base64}`;
            } else {
                console.error("PDF Base64 no disponible");
            }
        }
    })
    .catch(error => console.error('Error al obtener el PDF:', error));

    // Obtener la IP del usuario
    axios.get('https://api.ipify.org?format=json')
        .then(response => {
            userIp = response.data.ip;
        })
        .catch(error => console.error('Error al obtener la IP:', error));

    // Abrir modal de firma
    openModalBtn.addEventListener('click', () => {
        signatureModal.style.display = 'block';
        modalBackground.style.display = 'block';
    });

    // Cerrar modal
    closeModalBtn.addEventListener('click', () => {
        signatureModal.style.display = 'none';
        modalBackground.style.display = 'none';
    });

    // Limpiar firma
    clearSignatureBtn.addEventListener('click', () => {
        ctx.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
    });

    // Guardar firma
    saveSignatureBtn.addEventListener('click', () => {
        signatureImage = signatureCanvas.toDataURL();
      
        // Enviar firma al backend
        axios.post(`pdf.php?uuid_pdf=${uuidPdf}`, {
            firma: signatureImage,
            ip: userIp,
            documento_id: uuidPdf
        }, {
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log("response firma ", response)
            if (response.data.status === 'success') {
                alert('Firma guardada exitosamente');
                window.location.href = '/AlpeSegurosDev';
            } else {
                alert('Error al guardar la firma');
            }
        })
        .catch(error => console.error('Error al guardar la firma:', error));
    });

    // Función de dibujo en el canvas
    signatureCanvas.addEventListener('mousedown', (e) => {
        isDrawing = true;
        lastX = e.offsetX;
        lastY = e.offsetY;
    });

    signatureCanvas.addEventListener('mousemove', (e) => {
        if (isDrawing) {
            const currentX = e.offsetX;
            const currentY = e.offsetY;
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(currentX, currentY);
            ctx.stroke();
            lastX = currentX;
            lastY = currentY;
        }
    });

    signatureCanvas.addEventListener('mouseup', () => {
        isDrawing = false;
    });

    signatureCanvas.addEventListener('mouseout', () => {
        isDrawing = false;
    });
</script>

</body>
</html>
