<?php
session_start();
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true) {
    header("Location: Login.php");
    exit();
}

require_once 'assets/php/conexion.php'; // Conexión a la base de datos

// Array asociativo de laboratorios e IDs de equipos
$laboratorios = [
    'LDR' => 'salon_ldr',
    'LIA' => 'salon_lia',
    'LDS' => 'salon_lds',
    'LWI' => 'salon_lwi',
    'LTI' => 'salon_lti',
    'LIS' => 'salon_lis',
    'LTE' => 'salon_lte'
];

// Obtener datos del laboratorio LDR por defecto (puedes hacer esto dinámico si gustas)
$tablaActual = $laboratorios['LDR'];
$query = "SELECT ID_LDR, Descripcion, Marca, Modelo, Numero_Serie, Numero_ITJMM, Mesa, Numero_Posicion, SO, Procesador, RAM, Disco_Duro FROM $tablaActual";
$resultado = $conexion->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levantar Reporte</title>
    <link rel="stylesheet" href="assets/css/levantar_reporte.css">
</head>
<body>
    <?php require_once 'layouts/Header.php'; ?>
    <main>
        <div class="content-form">
            <h1>Levantar Reporte - Laboratorio LDR</h1>

            <form method="POST" action="assets/php/procesar_reporte.php">

            <input type="hidden" name="laboratorio" value="LDR">

                <div class="form-input">
                    <label for="equipo">Selecciona el equipo:</label>
                    <select id="equipo" name="equipo" required>
                        <option value="">--Seleccionar equipo--</option>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['ID_LDR']) ?>">
                                <?= $row['ID_LDR'] ?> - <?= $row['Descripcion'] ?> <?= $row['Modelo'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-input">
                    <label for="problema">Selecciona el tipo de problema:</label>
                    <select id="problema" name="problema" required>
                        <option value="">--Seleccionar problema--</option>
                        <option>No enciende</option>
                        <option>No da imagen</option>
                        <option>Pantalla azul</option>
                        <option>Sin periféricos</option>
                        <option>Sin internet</option>
                        <option>Falla de software</option>
                        <option>Otro</option>
                    </select>
                </div>

                <div class="form-input">
                    <label for="descripcion">Descripción del problema:</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Describe el problema con el equipo" required></textarea>
                </div>

                <button type="submit">Generar reporte</button>
            </form>
        </div>

        <img id="imagenLaboratorio" src="https://placehold.co/800x600" alt="Imagen del laboratorio">
    </main>

    <footer>
        <div class="logo-footer-izquierdo">
            <p>&copy; 2025 Realización de Reportes</p>
            <img src="img/Logos/tsj_logo_inferior.png" alt="Logo Footer" style="width: 400px; height: auto;">
        </div>
    </footer>
</body>
</html>
