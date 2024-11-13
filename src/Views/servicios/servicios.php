<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/boostrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include '../../includes/header.php'; ?>
   
    <div class="container" style="margin-top: 80px; margin-bottom: 40px;">
        <h3>NUESTROS SERVICIOS</h3>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100">
                    <img src="/Project/assets/images/IMG-20240823-WA0018.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Vacunación</h5>
                        <p class="card-text">OFRECEMOS VACUNACIÓN de acuerdo con las necesidades de tu mascota, garantizando su protección contra enfermedades comunes. Nuestros veterinarios calificados se aseguran de que tu animal reciba las vacunas necesarias en el momento adecuado para mantener su salud al máximo.</p>
                    </div>
                    <div class="card-footer">
                        <a href="">Más Información</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="/Project/assets/images/IMG-20240815-WA0017.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Alimentacíón</h5>
                        <p class="card-text">Ofrecemos una amplia variedad de alimentos de alta calidad para tus mascotas, adecuados para todas las edades y tamaños. Nuestros productos están diseñados para mantener a tu mascota saludable y llena de energía, con ingredientes naturales que aportan nutrición balanceada y sabor.</p>
                    </div>
                    <div class="card-footer">
                        <a href="/Project/src/Views/Productos/alimentacion.php">Más Información</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="/Project/assets/images/IMG-20240815-WA0016.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Consulta los productos</h5>
                        <p class="card-text">Descubre una variedad de productos cuidadosamente seleccionados para el bienestar de tus mascotas. Desde alimentos nutritivos hasta accesorios de calidad, cada uno de nuestros productos está diseñado para satisfacer las necesidades específicas de tu animal. Explora nuestras opciones y elige lo mejor para tu compañero.</p>
                    </div>
                    <div class="card-footer">
                        <a href="/Project/src/Views/Consulta/consulta.php">Más Información</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
