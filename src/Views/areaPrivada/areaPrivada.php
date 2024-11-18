<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="margin-top: 130px; margin-bottom: 80px;">
<?php include '../../includes/header.php'; ?>

<div class="private-area-container">
    <h1 class="header">Área Privada</h1>
    <p class="welcome-text">Bienvenido a tu espacio privado donde puedes gestionar todas tus opciones.</p>

   

    <!-- Sección de opciones adicionales -->
   
        <a href="/AlpeSegurosDev/src/Views/crearFormato/crearFormato.php">
            <button class="option-button">Agregar tarifa</button>
        </a>

        <a href="/AlpeSegurosDev/src/Views/crearFormato/crearFormato.php">
            <button class="option-button">Ingresar formato</button>
        </a>
    

    <!-- Texto explicativo -->
    <div class="info-section">
        <p>Desde aquí podrás agregar nuevas tarifas, ingresar formatos personalizados y gestionar tu cuenta.</p>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
</html>