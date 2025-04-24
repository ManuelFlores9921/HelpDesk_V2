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
    <title>Crear Cuenta</title>
    <link rel="stylesheet" href="assets/css/estilos_login.css">
</head>
<body>
    <header>
        <div class="navbar">
            <img src="img/Logos/tsj_logo.png" alt="Logo" style="width: 200px; height: auto;">
        </div>
    </header>

    <main>
        <h1>Crear Cuenta</h1>
        <form action="assets/php/registro.php" method="POST">
            <input type="text" placeholder="Nombre" name="Nombre" required>
            <input type="email" placeholder="Correo" name="Correo" required>
            <input type="text" placeholder="numero de Empleado" name="num_emp" required>
            <select name="Puesto" required>
                <option value="" disabled selected>Selecciona un rol</option>
                <option value="Jefe Carrera">Jefe Carrera</option>
                <option value="Jefe Mantenimiento">Jefe Mantenimiento</option>
                <option value="Tecnico">Tecnico</option>
                <option value="Laboratorista">Laboratorista</option>
                <option value="Profesor">Profesor</option>
            </select>
            <button type="submit">registrar Usuario</button>
        </form>
    </main>

    <footer>
        <div class="logo-footer-izquierdo">
            <p>&copy; 2025 Realización de Reportes</p>
            <img src="img/Logos/tsj_logo_inferior.png" alt="Logo Footer" style="width: 400px; height: auto; align-items: center;">
        </div>
    </footer>
</body>
</html>
