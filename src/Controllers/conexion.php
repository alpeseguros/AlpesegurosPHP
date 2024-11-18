<?php
$servername = "localhost";
$username = "root"; // Usuario por defecto de MySQL en XAMPP
$password = ""; // Contraseña por defecto es vacía
$dbname = "alpeseguros"; // Cambia esto por el nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
