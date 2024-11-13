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
    <title>Document</title>
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
            <div class="col-lg-6 col-md-12 col-12">
                <img src="ftr.png" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-12 ps-lg-5 mt-md-5">
                <h2>FINCA SANA</h2>
                <p>Aquí podrás encontrar productos para el cuidado de los animales, tanto en su alimentación como en su salud. Es muy importante mantenerlos en las mejores condiciones posibles para garantizar su bienestar y productividad.</p>
            </div>
        </div>
    </div>
</section>   

<section class="about section-padding mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-12">
                <img src="assets/images/ftr.png" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-12 ps-lg-5 mt-md-5">
                <h2>Servicios de Alimentación y Salud Animal</h2>
                <p>En FINCA SANA, ofrecemos productos especializados para la nutrición y el cuidado de diversos animales. Nos aseguramos de que cada uno reciba lo necesario para mantener su salud y energía, adaptándonos a las necesidades de cada especie.</p>
            </div>
        </div>
    </div>
</section>

<section class="services section-padding mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-12 ps-lg-5 mt-md-5">
                <h2>Asesoría Profesional para el Cuidado Animal</h2>
                <p>En FINCA SANA, brindamos asesoría experta sobre el manejo adecuado de los animales, enfocándonos en su bienestar general, desde la prevención de enfermedades hasta el cuidado de su alimentación. Nuestro objetivo es garantizar una vida saludable y productiva para tus animales.</p>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <!-- Puedes agregar una imagen o cualquier contenido adicional aquí si lo deseas -->
                <img src="assets/images/le.jpg" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section>

<?php include 'src/includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
