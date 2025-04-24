<nav>
    <img src="img/Logos/tsj_logo.png" alt="Logo" class="logo">
    <div class="links">
        <span><a href="index.php">Inicio</a></span>
        <?php
        if (!in_array($_SESSION['rol'], ['Profesor', 'Laboratorista'])) {
            echo '<span><a href="Reportes.php">Reportes</a></span>';
        }
        ?>
        <select onchange="location = this.value;">
            <option selected disabled>Realizar reporte</option>
            <option value="LDR.php">LDR</option>
            <option value="LIA.php">LIA</option>
            <option value="LDS.php">LDS</option>
            <option value="LWI.php">LWI</option>
            <option value="LTI.php">LTI</option>
            <option value="LIS.php">LIS</option>
            <option value="LTE.php">LTE</option>
        </select>
        <span><a href="Laboratorios.php">Laboratorios</a></span>
        <?php
        if ($_SESSION['rol'] == 'Jefe Mantenimiento') {
            echo '<span><a href="Actualizar.php">Actualizar Inventario</a></span>';
            echo '<span><a href="Actualizacion_Manual.php">Actualizacion Manual</a></span>';
            echo '<span><a href="Lista_Laboratorio.php">Lista Laboratorios</a></span>';
        }
        ?>
        <?php
        if ($_SESSION['rol'] == 'Jefe Carrera') {
            echo '<span><a href="Crear_Cuenta.php">Crear</a></span>';
            echo '<span><a href="Actualizacion_Manual.php">Actualizacion Manual</a></span>';
            echo '<span><a href="Lista_Laboratorio.php">Lista Laboratorios</a></span>';
        }
        ?>
    </div>
    <div class="user">
        <div class="logout">            
            <span><a href="assets/php/logout.php">Cerrar sesión</a></span>
           
        </div>
        <img src="https://placehold.co/50" alt="Imagen Usuario" class="user-img" />
    </div>
</nav>