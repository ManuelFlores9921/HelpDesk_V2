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
    <title>Reportes</title>
</head>

<body>
    <!-- Modal para asignar técnico -->
    <div id="modalAsignar" class="modal">
        <?php
        $query_tecnicos = "SELECT idusuarios, Nombre FROM usuarios WHERE Puesto = 'Tecnico Mantenimiento'";
        $resultado_tecnicos = $conexion->query($query_tecnicos);
        ?>
        <div class="modal-contenido">
            <span class="cerrar">&times;</span>
            <h2>Asignar Técnico</h2>
            <form action="../HelpDesk/assets/php/asignar_tecnico.php" method="POST">
                <input type="hidden" name="id_reporte" id="modal_id_reporte">

                <label for="tecnico">Selecciona un técnico:</label>
                <select name="tecnico" id="tecnico-select" required>
                    <option value="">-- Selecciona un técnico --</option>
                    <?php while ($tecnico = $resultado_tecnicos->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($tecnico['idusuarios']); ?>">
                            <?php echo $tecnico['Nombre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <button type="submit">Asignar</button>
            </form>
        </div>
    </div>

    <!-- Modal para actualizar estatus -->
    <div id="modalEstatus" class="modal">
        <div class="modal-contenido">
            <span class="cerrar-estatus">&times;</span>
            <h2>Actualizar Estatus del Reporte</h2>
            <form action="../HelpDesk/assets/php/actualizar_estatus.php" method="POST">
                <input type="hidden" name="id_reporte" id="modal_estatus_id_reporte">

                <label for="nuevo_estatus">Selecciona el nuevo estatus:</label>
                <select name="nuevo_estatus" id="nuevo_estatus" required>
                    <option value="">-- Selecciona un estatus --</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="En Revision">En Revision</option>
                    <option value="Completado">Completado</option>
                </select>

                <button type="submit">Actualizar</button>
            </form>
        </div>
    </div>

    <!-- Barra de navegación -->
    <?php require_once 'layouts/Header.php'; ?>

    <h1 style="text-align: center;">Reportes</h1>
    <div class="table-container">
        <?php
        $query = "SELECT * FROM reportes";
        $resultado = $conexion->query($query);

        if ($resultado && $resultado->num_rows > 0) {
            echo '<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID_LAB</th>
                        <th>Descripción</th>
                        <th>Modelo</th>
                        <th>Numero Serie</th>
                        <th>Numero ITJMM</th>
                        <th>Mesa</th>
                        <th>Problema</th>
                        <th>Descripcion del Problema</th>
                        <th>Estatus</th>
                        <th>Tecnico</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';

            while ($fila = $resultado->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($fila['ID_Reporte'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($fila['ID_LAB'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($fila['Descripcion'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($fila['Modelo'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($fila['Numero_Serie'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($fila['Numero_ITJMM'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($fila['Mesa'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($fila['Problema'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($fila['Descripcion_Problema'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($fila['Estatus'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($fila['Tecnico'] ?? '') . '</td>';
                echo '<td><div class="buttons">';
                if ($fila['Tecnico'] === 'Sin Asignar') {
                    echo '<span style="color: red; font-weight: bold;">Sin técnico asignado</span><br>';
                    echo '<button type="button" onclick="abrirModal(' . $fila['ID_Reporte'] . ')">Asignar Técnico</button>';
                } else {
                    echo '<span style="color: green; font-weight: bold;">Técnico asignado</span><br>';
                    echo '<button type="button" onclick="abrirModalEstatus(' . $fila['ID_Reporte'] . ')">Actualizar Estatus</button>';
                }
                echo '</div></td>';

                echo '</tr>';
            }

            echo '</tbody></table>';
        } else {
            echo "<p>No se encontraron datos en el laboratorio seleccionado.</p>";
        }
        ?>
    </div>

    <footer>
        <div class="logo-footer-izquierdo">
            <p>&copy; 2025 Realización de Reportes</p>
            <img src="img/Logos/tsj_logo_inferior.png" alt="Logo Footer" style="width: 400px; height: auto;">
        </div>
    </footer>

    <!-- Asignar Tecnico -->
    <script>
        const modal = document.getElementById("modalAsignar");
        const spanCerrar = document.querySelector(".cerrar");

        function abrirModal(idReporte) {
            document.getElementById("modal_id_reporte").value = idReporte;
            modal.style.display = "block";
        }

        spanCerrar.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
    
    <!-- Actualizar Estatus -->
    <script>
    const modalEstatus = document.getElementById("modalEstatus");
    const spanCerrarEstatus = document.querySelector(".cerrar-estatus");

    function abrirModalEstatus(idReporte) {
        document.getElementById("modal_estatus_id_reporte").value = idReporte;
        modalEstatus.style.display = "block";
    }

    spanCerrarEstatus.onclick = function () {
        modalEstatus.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        } else if (event.target === modalEstatus) {
            modalEstatus.style.display = "none";
        }
    }
</script>


</body>
</html>