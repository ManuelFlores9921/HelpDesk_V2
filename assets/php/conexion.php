<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "helpdesk";

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4"); // ¡Esto es crucial!
?>