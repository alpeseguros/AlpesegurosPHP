<?php

include "conexion.php";

$nombre=$_POST['nombre_apellido'];
$telefono=$_POST['telefono'];
$correo=$_POST['correo'];
$direccion=$_POST['direccion'];
$cantidad=$_POST['cantidad'];


$insertar INSERT INTO pedidos ("nombre_apellido, telefono,correo,direccion,cantidad")
VALUES ($nombre, $telefono, $correo, $direccion,$cantidad);






?>