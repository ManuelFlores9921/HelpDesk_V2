<?php 
session_start();
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true) {
    header("Location: Login.php");
    exit();
}
require 'assets/php/conexion.php'; // Asegúrate de que este archivo tenga la conexión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reportes.css">
    <title>Lista Laboratorios</title>
</head>
<body>
    <?php require_once 'layouts/Header.php'; ?>

    <h1 style="text-align: center;">Laboratorios</h1>
    <form class="selector_laboratorio" method="GET">
        <label for="laboratorio">Seleccionar laboratorio:</label>
        <select id="laboratorio" name="laboratorio">
            <option value="">-- Selecciona una opción --</option>
            <option value="salon_ldr">Laboratorio de Redes</option>
            <option value="salon_lia">Laboratorio de IA</option>
            <option value="salon_lds">Laboratorio de Sistemas</option>
            <option value="salon_lwi">Laboratorio de Web</option>
            <option value="salon_lti">Laboratorio de TI</option>
            <option value="salon_lis">Laboratorio de Seguridad</option>
            <option value="salon_lte">Laboratorio de Electrónica</option>
        </select>
        <button type="submit">Mostrar</button>
    </form>

    <div class="table-container">
        <?php
        if (isset($_GET['laboratorio']) && $_GET['laboratorio'] !== '') {
            $laboratorio = $_GET['laboratorio'];

            // Validar contra lista blanca
            $permitidos = ['salon_ldr', 'salon_lia', 'salon_lds', 'salon_lwi', 'salon_lti', 'salon_lis', 'salon_lte'];
            if (in_array($laboratorio, $permitidos)) {
                $sql = "SELECT * FROM `$laboratorio`";
                $resultado = $conexion->query($sql);

                if ($resultado && $resultado->num_rows > 0) {
                    echo '<table>
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Numero Serie</th>
                                    <th>Numero ITJMM</th>
                                    <th>Mesa</th>
                                    <th>Numero Posición</th>
                                    <th>SO</th>
                                    <th>Procesador</th>
                                    <th>RAM</th>
                                    <th>Disco Duro</th>
                                    <th>Tarjeta</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>';

                    while ($fila = $resultado->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($fila['Descripcion']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['Marca']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['Modelo']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['Numero_Serie']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['Numero_ITJMM']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['Mesa']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['Numero_Posicion']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['SO']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['Procesador']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['RAM']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['Disco_Duro']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['Tarjeta']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['Estado']) . '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody></table>';
                } else {
                    echo "<p>No se encontraron datos en el laboratorio seleccionado.</p>";
                }
            } else {
                echo "<p>Laboratorio no permitido.</p>";
            }
        } else {
            echo "<p style='text-align: center;'>Por favor selecciona un laboratorio para mostrar los reportes.</p>";
        }
        ?>
    </div>

    <footer>
        <div class="logo-footer-izquierdo">
            <p>&copy; 2025 Realización de Reportes</p>
            <img src="img/Logos/tsj_logo_inferior.png" alt="Logo Footer" style="width: 400px; height: auto;">
        </div>
    </footer>
</body>
</html>
