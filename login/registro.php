<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
<form>
  <div class="container">
   <form action="insetar.php" method="post">
    <h3>Formulario de registro</h3>
    <select class="form-select" aria-label="Default select example">
  <option selected>tipo documento</option>
  <option value="1">cedula de ciudadania</option>
  <option value="2">tarjeta de credito</option>
  <option value="3">registro civil</option>
  <option value="2">cedula extranjera</option>
  <option value="3">otro</option>
</select>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">documento</label>
    <input type="text" class="form-control" name="nombre_completo" aria-describe="emailHELP" placeholder="ingrese el docomuneto">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">nombre y apellido</label>
    <input type="text" class="form-control" name="nombre_completo" aria-describe="emailHELP" placeholder="ingrese el nombre y apellido">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">celular</label>
    <input type="text" class="form-control" name="nombre_completo" aria-describe="emailHELP" placeholder="ingrese el número de celular">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">usuario</label>
    <input type="text" class="form-control" name="nombre_completo" aria-describe="emailHELP" placeholder="ingrese tú usuario">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">contraseña</label>
    <input type="text" class="form-control" name="nombre_completo" aria-describe="emailHELP" placeholder="ingrese la contraseña">
  </div>
  <div class="mb-3">
    <select class="form-select" aria-label="Default select example">
  <option selected>seleccione un rol</option>
  <option value="1">admin</option>
  <option value="2">cliente</option>
  <option value="3">vendedor</option>
</select>
<div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>