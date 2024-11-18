<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
$is_authenticated = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlpeSeguros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'src/includes/header.php'; ?>
<br>
<?php include 'src/includes/carrusel.php'; ?>

<section class="about section-padding mt-5">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-lg-6 col-md-12 col-12 ps-lg-5 mt-md-5">
                <h2>Bienvenido a AlpeSeguros</h2>
                <p>En AlpeSeguros nos dedicamos a brindarte la tranquilidad que necesitas con nuestros seguros personalizados. Ya sea para proteger tu hogar, automóvil, o tus seres queridos, contamos con opciones que se adaptan a tus necesidades y presupuesto.</p>
            </div>
        </div>
    </div>
</section>   

<section class="about section-padding mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-12">
                <img src="assets/images/IMG-20241104-WA0010.jpg" class="img-fluid" alt="AlpeSeguros">
            </div>
            <div class="col-lg-6 col-md-12 col-12 ps-lg-5 mt-md-5">
                <h2>Protección y Seguridad para Tu Vida y Tus Bienes</h2>
                <p>Con AlpeSeguros, puedes estar seguro de que tus bienes más valiosos están protegidos. Ofrecemos seguros de salud, vida, automotriz y hogar, asegurando que cada aspecto de tu vida esté cubierto contra imprevistos.</p>
            </div>
        </div>
    </div>
</section>

<section class="services section-padding mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-12 ps-lg-5 mt-md-5">
                <h2>Asesoría Profesional en Seguros</h2>
                <p>En AlpeSeguros, nuestro equipo de expertos está listo para ayudarte a encontrar la mejor cobertura para tus necesidades. Nos esforzamos por ofrecer asesoría personalizada que se adapte a cada situación, garantizando la tranquilidad y seguridad que mereces.</p>
            </div>
            
        </div>
    </div>
</section>

<?php include 'src/includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
