<?php
// Conectar a la base de datos
include 'C:\xampp\htdocs\Project\src\Controllers\conexion.php'; // Asegúrate de que la ruta a tu archivo de conexión sea correcta

// Verificar que se enviaron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre']; // Asegúrate de que este campo coincida con el nombre en el HTML
    $apellido = ''; // Asignar valor vacío si no se proporciona
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $fecha = date("Y-m-d"); // Asignar fecha actual
    $id_query = uniqid(true);
    $precio=$_POST['precio'];
    $precio = floatval($precio); 
    
    // Preparar la consulta SQL
    $sql = "INSERT INTO compras (nombre, apellido, correo, producto, cantidad, telefono, direccion, fecha,precio,pagado) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisssd", $nombre, $apellido, $correo, $producto, $cantidad, $telefono, $direccion, $fecha,$precio);



    $sqlCarrito = "INSERT INTO carrito_compras (nombre_apellido, usuario, telefono, correo, direccion, producto, cantidad, fecha_agregado, id_query, precio, pagado, in_cart) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 1)";

    $stmtCarrito = $conn->prepare($sqlCarrito);

    // Convertir precio a decimal
    $precio = floatval($precio);

    // Bind de los parámetros con los tipos de datos correctos
    $stmtCarrito->bind_param("ssssssssid", $nombre, $nombre, $telefono, $correo, $direccion, $producto, $cantidad, $fecha, $id_query, $precio);

    // Ejecutar la consulta
    if (!$stmtCarrito->execute()) {
        throw new Exception("Error al guardar en la tabla carrito_compras: " . $stmtCarrito->error);
    }



    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Datos guardados correctamente.";
    } else {
        echo "Error al guardar los datos: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();

    // Redirigir al usuario al menú principal
    header("Location: /Project/index.php");
    exit();
} else {
    echo "No se enviaron datos del formulario.";
}
?>
