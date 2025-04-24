<?php session_start();
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true) {
    header("Location: Login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar - HelpDesk</title>
    <link rel="stylesheet" href="assets/css/actualizar.css"> <!-- Archivo CSS -->
</head>

<body>
    <!-- Barra de navegación -->
    <?php require_once 'layouts/Header.php'; ?>

    <!-- Contenido principal -->
    <main class="container">
        <h1>Actualizar Archivos</h1>
        <p>Sube un archivo Excel para actualizar los datos:</p>
        <form action="../HelpDesk/assets/php/actualizar_DB.php" method="post" enctype="multipart/form-data">
            <label for="salon">Selecciona el salón:</label>
            <select name="salon" id="salon" required>
                <option value="" disabled selected>-- Selecciona un salón --</option>
                <option value="salon_ldr">LDR</option>
                <option value="salon_lia">LIA</option>
                <option value="salon_lds">LDS</option>
                <option value="salon_lwi">LWI</option>
                <option value="salon_lti">LTI</option>
                <option value="salon_lis">LIS</option>
                <option value="salon_lte">LTE</option>
            </select>

            <label for="excelFile">Selecciona un archivo Excel (.csv/.xlsx):</label>
            <input type="file" id="excelFile" name="excelFile" accept=".xls, .xlsx" required>

            <button type="submit" class="btn">Cargar Archivo</button>
        </form>

    </main>

    <!-- Pie de página -->
    <footer>
        <div class="logo-footer-izquierdo">
            <p>&copy; 2025 Realización de Reportes</p>
            <img src="img/Logos/tsj_logo_inferior.png" alt="Logo Footer">
        </div>
    </footer>
</body>

</html>