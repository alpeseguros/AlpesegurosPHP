
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body  style="margin-top: 120px;">
<?php include '../../includes/header.php'; ?>

    <section class="container mt-5" >
        <h3>Escríbenos para tener el gusto de atenderte</h3>
        <form action="/Project/src/Controllers/formulario_contacto.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" name="telefono" id="telefono" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" name="correo" id="correo" aria-describedby="emailHelp" required>
            </div>
            <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Escribe tu mensaje aquí" id="comentarios" name="comentarios" style="height: 100px" required></textarea>
                <label for="comentarios">Comentarios</label>
            </div>
            <button type="submit" class="btn btn-primary">Enviar datos</button>
        </form>
    </section >

<?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
