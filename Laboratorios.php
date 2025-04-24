<?php session_start();
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true) {
    header("Location: Login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/laboratorios.css">
    <title>Laboratorios</title>
</head>

<body>
    <!-- Barra de navegación -->
    <?php require_once 'layouts/Header.php'; ?>

    <main>
        <h1>Laboratorios</h1>
        <label for="laboratorios">Selecciona un laboratorio:</label>
        <select id="laboratorios" onchange="mostrarImagen(this.value)">
            <option value="">--Selecciona--</option>
            <option value="LDR">LDR</option>
            <option value="LTI">LTI</option>
            <option value="LWI">LWI</option>
            <option value="LDS">LDS</option>
            <option value="LIA">LIA</option>
            <option value="LIS">LIS</option>
            <option value="LTE">LTE</option>
        </select>
        <div class="laboratorio-imagen">
            <img id="imagenLaboratorio" src="imagenes/default.jpg" alt="Selecciona un laboratorio">
        </div>
    </main>

    <footer>
        <div class="logo-footer-izquierdo">
            <p>&copy; 2025 Realización de Reportes</p>
            <img src="img/Logos/tsj_logo_inferior.png" alt="Logo Footer">
        </div>
    </footer>
</body>

</html>