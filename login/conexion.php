<?php
$hostname="localhost";
$username="root";
$password="";
$bdname="login";

$conexion=mysqli_connect($hostname,$username,$password,$bdname);
echo"la conexion a la base de datos es exitosa";
?>