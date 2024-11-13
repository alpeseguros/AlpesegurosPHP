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
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 
    <?php include '../../includes/header.php'; ?>
    <div class="container"  style="margin-top: 120px; margin-bottom: 80px">
        <h3>Conoce un poco de nosotros</h3>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="card">
                    <img src="/Project/assets/images/vacas.jpg.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Nuestra Misión</h5>
                        <p class="card-text">En nuestra empresa, nos dedicamos a mejorar la calidad de vida de las mascotas y sus dueños. Creemos en un enfoque integral de bienestar animal, proporcionando servicios de salud, nutrición y cuidado preventivo que aseguran la felicidad y salud de tu compañero más fiel. Nuestro equipo de profesionales está comprometido con cada animal, brindando atención personalizada y soluciones innovadoras.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="/Project/assets/images/IMG-20240827-WA0042.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Nuestra Visión</h5>
                        <p class="card-text">Queremos ser reconocidos como la empresa líder en bienestar animal, comprometidos con la innovación y la educación continua. Buscamos transformar el cuidado de las mascotas, estableciendo un nuevo estándar en la industria. Nuestra visión es crear un mundo donde todas las mascotas reciban la atención que se merecen, asegurando su salud y felicidad durante toda su vida.</p>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card">
                    <img src="/Project/assets/images/11.jpeg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Nuestros Servicios</h5>
                        <p class="card-text">Ofrecemos una amplia gama de servicios para el bienestar de tus mascotas, desde consultas veterinarias hasta asesoramiento en alimentación, comportamiento y productos especializados. Además, contamos con un servicio de urgencias y cuidado preventivo, asegurándonos de que tu mascota reciba la atención adecuada en todo momento.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>
</body>

</html>
