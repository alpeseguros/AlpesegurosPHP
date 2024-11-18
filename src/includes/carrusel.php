

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrusel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .carousel-container {
            margin-top: 50px; /* Ajusta la distancia desde la parte superior */
        }
        .carousel-inner img {
            height: 100vh; /* Ajusta la altura del carrusel para llenar toda la altura de la pantalla */
            object-fit: contain; /* Mantiene la imagen completa sin recortes */
            width: 100%; /* Asegura que la imagen ocupe todo el ancho */
        }
    </style>
</head>

<body>
<div id="caruselE" class="carousel slide carousel-container" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#caruselE" data-bs-slide-to="0" class="active" aria-current="true" aria-label="slide 1"></button>
        <button type="button" data-bs-target="#caruselE" data-bs-slide-to="1" aria-label="slide 2"></button>
        <button type="button" data-bs-target="#caruselE" data-bs-slide-to="2" aria-label="slide 3"></button>
    </div>

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/AlpeSegurosDev/assets/images/IMG-20241104-WA0010.jpg" class="d-block w-100" alt="..." width="300" height="200">
            <div class="carousel-caption d-none d-md-block">
                <h5>FINCA SANA, Somos calidad.</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img src="/AlpeSegurosDev/assets/images/IMG-20241104-WA0010.jpg" class="d-block w-100" alt="..." width="300" height="200">
            <div class="carousel-caption d-none d-md-block">
                <h5>FINCA SANA, Somos calidad.</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img src="/AlpeSegurosDev/assets/images/IMG-20241104-WA0010.jpg" class="d-block w-100" alt="..." width="300" height="200">
            <div class="carousel-caption d-none d-md-block">
                <h5>FINCA SANA, Somos calidad.</h5>
            </div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#caruselE" data-bs-slide="prev" style="background-color: #00000099;">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#caruselE" data-bs-slide="next" style="background-color: #00000099;">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
