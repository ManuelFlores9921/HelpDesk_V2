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
    <title>Ayuda - Uso de la Página de Reportes</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <!-- Barra de navegación -->
    <?php require_once 'layouts/Header.php'; ?>

    <main>
        <section>
            <h2>¿Cómo utilizar la página web?</h2> <br><br>
            <p>Esta página está diseñada para facilitar el reporte de errores en equipos de cómputo. A continuación, se describe cómo utilizar cada sección:</p> <br><br>
        </section>
        <section>
            <h3>1. Página de Inicio</h3><br><br>
            <p>Desde la página de inicio, puedes navegar a las diferentes secciones del sitio utilizando el menú superior.</p><br><br>
        </section>
        <section>
            <h3>2. Reportar Problema</h3><br><br>
            <p>En esta sección, puedes llenar un formulario para reportar cualquier problema técnico con los equipos de cómputo. Asegúrate de proporcionar información detallada.</p><br><br>
        </section>
        <section>
            <h3>3. Historial de Reportes</h3><br><br>
            <p>Aquí puedes consultar el estado de los reportes que has realizado previamente. Podrás ver si están en proceso o si ya han sido resueltos.</p><br><br>
        </section>
        <section>
            <h3>4. Ayuda</h3><br><br>
            <p>En esta sección, encontrarás información sobre cómo utilizar la página y resolver dudas comunes.</p><br><br>
        </section>
    </main>
    <footer>
        <div class="logo-footer-izquierdo">
            <p>&copy; 2025 Realización de Reportes</p>
            <img src="img/Logos/tsj_logo_inferior.png" alt="Logo Footer" style="width: 400px; height: auto; align-items: center;">
        </div>
    </footer>
</body>
</html>