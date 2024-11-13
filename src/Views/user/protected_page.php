<?php
session_start([
    'cookie_lifetime' => 86400,
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Regenerar el ID de sesión para prevenir fijación de sesión
session_regenerate_id(true);

// Código de la página protegida aquí

// Cierre de sesión seguro
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Página Protegida</title>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <a href="?logout">Cerrar sesión</a>
</body>
</html>
