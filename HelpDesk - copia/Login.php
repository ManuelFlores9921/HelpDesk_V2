<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="assets/css/estilos_login.css">
</head>
<body>
    <header>
        <div class="navbar">
            <img src="img/Logos/tsj_logo.png" alt="Logo" style="width: 200px; height: auto;">
        </div>
    </header>

    <main>
        <h1>Inicio de Sesión</h1>
        <form id="loginForm" method="post" action="assets/php/Login.php">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            <label for="num_emp">Numero de Empleado:</label>
            <input type="text" id="num_emp" name="num_emp" required>
            <button type="submit" name="login">Iniciar Sesión</button>
        </form>
    </main>

    <footer>
        <div class="logo-footer-izquierdo">
            <p>&copy; 2025 Realización de Reportes</p>
            <img src="img/Logos/tsj_logo_inferior.png" alt="Logo Footer" style="width: 400px; height: auto; align-items: center;">
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>