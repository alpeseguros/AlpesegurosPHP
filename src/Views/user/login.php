<?php
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php';
session_start(); // Iniciar la sesión

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar datos del formulario
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Validación simple
    if (empty($username) || empty($password)) {
        $error = "Nombre de usuario y contraseña son requeridos.";
    } else {
        // Preparar la consulta SQL para buscar el usuario y tipo_cliente
        $sql = "SELECT id, password, tipo_cliente FROM usuarios WHERE nombre = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // El usuario existe, obtener los datos
            $stmt->bind_result($user_id, $hashed_password, $tipo_cliente);
            $stmt->fetch();

            // Verificar la contraseña
            if (password_verify($password, $hashed_password)) {
                // Contraseña correcta, iniciar sesión
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['tipo_cliente'] = $tipo_cliente; // Guardar tipo_cliente en la sesión
                
                header("Location: /AlpeSegurosDev"); // Redirigir a una página protegida
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Nombre de usuario no encontrado.";
        }

        // Cerrar la declaración
        $stmt->close();
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 300px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 8px;
        }
        .btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php include '../../includes/header.php'; ?>

<div class="container">
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
