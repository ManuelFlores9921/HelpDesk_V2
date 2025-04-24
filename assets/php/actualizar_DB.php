<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excelFile']) && isset($_POST['salon'])) {
    $archivo = $_FILES['excelFile']['tmp_name'];
    $tabla = $_POST['salon'];

    // Lista blanca de tablas permitidas
    $tablas_permitidas = ['salon_ldr', 'salon_lia', 'salon_lds', 'salon_lwi', 'salon_lti', 'salon_lis', 'salon_lte'];
    if (!in_array($tabla, $tablas_permitidas)) {
        die("Tabla no permitida.");
    }

    if (file_exists($archivo)) {
        require 'conexion.php';

        $lineas = file($archivo);
        $i = 0;

        foreach ($lineas as $linea) {
            $datos = str_getcsv(trim($linea), ",");

            if ($i == 0) {
                $i++;
                continue; // Saltar encabezado
            }

            // Validar que haya al menos 13 columnas
            if (count($datos) < 13) {
                echo "Línea $i ignorada: número insuficiente de columnas.<br>";
                $i++;
                continue;
            }

            // Asignar valores o 'NA' si está vacío
            $Descripcion   = !empty($datos[0]) ? $datos[0] : 'NA';
            $Marca         = !empty($datos[1]) ? $datos[1] : 'NA';
            $Modelo        = !empty($datos[2]) ? $datos[2] : 'NA';
            $Num_Serie     = !empty($datos[3]) ? $datos[3] : 'NA';
            $Num_ITJMM     = !empty($datos[4]) ? $datos[4] : 'NA';
            $Mesa          = !empty($datos[5]) ? $datos[5] : 0;
            $Num_Posicion  = !empty($datos[6]) ? $datos[6] : 0;
            $SO            = !empty($datos[7]) ? $datos[7] : 'NA';
            $Procesador    = !empty($datos[8]) ? $datos[8] : 'NA';
            $RAM           = !empty($datos[9]) ? $datos[9] : 'NA';
            $Disco_Duro    = !empty($datos[10]) ? $datos[10] : 'NA';
            $Tarjeta       = !empty($datos[11]) ? $datos[11] : 'NA';
            $Estado        = !empty($datos[12]) ? $datos[12] : 'ACTIVO';

            // Preparar sentencia SQL
            $sql = "INSERT INTO `$tabla` 
                (Descripcion, Marca, Modelo, Numero_Serie, Numero_ITJMM, Mesa, Numero_Posicion, SO, Procesador, RAM, Disco_Duro, Tarjeta, Estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en prepare: " . $conexion->error);
            }

            $stmt->bind_param("ssssiisssssss", $Descripcion, $Marca, $Modelo, $Num_Serie, $Num_ITJMM, $Mesa, $Num_Posicion, $SO, $Procesador, $RAM, $Disco_Duro, $Tarjeta, $Estado);

            if (!$stmt->execute()) {
                echo "Error en ejecución (línea $i): " . $stmt->error . "<br>";
            }

            $i++;
        }

        // Cierre limpio
        $stmt->close();
        $conexion->close();

        echo "<script>alert('Datos cargados exitosamente en $tabla'); window.location='Actualizar.php';</script>";
    } else {
        echo "<script>alert('Error al subir el archivo.'); window.location='Actualizar.php';</script>";
    }
}
?>