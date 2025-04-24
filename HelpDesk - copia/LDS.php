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
    <link rel="stylesheet" href="assets/css/levantar_reporte.css">
</head>

<body>
    <!-- Barra de navegación -->
    <?php require_once 'layouts/Header.php'; ?>

    <main>

        <div class="content-form">
            <h1>Laboratorio LDS</h1>

            <div class="form-input">
                <label for="laboratorios">Selecciona el equipo:</label>
                <select id="laboratorios" name="equipo" required>
                    <option value="">--Seleccionar equipo--</option>
                    <option value="equipo1">Equipo 1</option>
                    <option value="equipo2">Equipo 2</option>
                    <option value="equipo3">Equipo 3</option>
                    <option value="equipo4">Equipo 4</option>
                    <option value="equipo5">Equipo 5</option>
                    <option value="equipo6">Equipo 6</option>
                    <option value="equipo7">Equipo 7</option>
                    <option value="equipo8">Equipo 8</option>
                    <option value="equipo9">Equipo 9</option>
                    <option value="equipo10">Equipo 10</option>
                    <option value="equipo11">Equipo 11</option>
                    <option value="equipo12">Equipo 12</option>
                    <option value="equipo13">Equipo 13</option>
                    <option value="equipo14">Equipo 14</option>
                    <option value="equipo15">Equipo 15</option>
                    <option value="equipo16">Equipo 16</option>
                    <option value="equipo17">Equipo 17</option>
                    <option value="equipo18">Equipo 18</option>
                    <option value="equipo19">Equipo 19</option>
                    <option value="equipo20">Equipo 20</option>
                    <option value="equipo21">Equipo 21</option>
                    <option value="equipo22">Equipo 22</option>
                    <option value="equipo23">Equipo 23</option>
                    <option value="equipo24">Equipo 24</option>
                </select>
            </div>
            <div class="form-input">
                <label for="laboratorios">Selecciona el tipo de problema:</label>
                <select id="laboratorios" name="problema" required>
                    <option>No enciende</option>
                    <option>No da imagen</option>
                    <option>Pantalla azul</option>
                    <option>Sin perifericos</option>
                    <option>Sin internet</option>
                    <option>Falla de Software</option>
                    <option>otro</option>
                </select>
            </div>
            <div class="form-input">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" placeholder="Describe el problema con el equipo"
                    required></textarea>
            </div>
            <button>Generar reporte</button>
        </div>
        <img id="imagenLaboratorio" src="https://placehold.co/800x600" alt="Imagen del laboratorio">
    </main>

    <footer>
        <div class="logo-footer-izquierdo">
            <p>&copy; 2025 Realización de Reportes</p>
            <img src="img/Logos/tsj_logo_inferior.png" alt="Logo Footer"
                style="width: 400px; height: auto; align-items: center;">
        </div>
    </footer>
</body>

</html>