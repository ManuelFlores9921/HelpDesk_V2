<?php
session_start();
require_once 'conexion.php';

// Verificar que se recibió el formulario correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar campos requeridos
    if (empty($_POST['equipo']) || empty($_POST['problema']) || empty($_POST['descripcion'])) {
        echo "<script>alert('Por favor completa todos los campos.'); window.history.back();</script>";
        exit;
    }

    // Obtener valores del formulario
    $id_equipo = $_POST['equipo'];
    $tipo_problema = $_POST['problema'];
    $descripcion_problema = $_POST['descripcion'];
    $laboratorio = $_POST['laboratorio'];

    // Mapeo de prefijos de ID a sus respectivas tablas
    $id_a_tabla = [
        'LDR' => 'salon_ldr',
        'LIA' => 'salon_lia',
        'LDS' => 'salon_lds',
        'LWI' => 'salon_lwi',
        'LTI' => 'salon_lti',
        'LIS' => 'salon_lis',
        'LTE' => 'salon_lte'
    ];

    if (!array_key_exists($laboratorio, $id_a_tabla)) {
        echo "<script>alert('Laboratorio no válido.'); window.history.back();</script>";
        exit;
    }
    
    $tabla = $id_a_tabla[$laboratorio]; // ej: salon_ldr
    $id_columna = "ID_" . $laboratorio; // ej: ID_LDR

    // Consultar datos del equipo desde la tabla correspondiente
    $query = $conexion->prepare("SELECT 
        $id_columna,
        Descripcion,
        Marca,
        Modelo,
        Numero_Serie,
        Numero_ITJMM,
        Mesa,
        Numero_Posicion,
        SO,
        Procesador,
        RAM,
        Disco_Duro
        FROM $tabla WHERE $id_columna = ?");
    
    $query->bind_param("s", $id_equipo);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows === 0) {
        echo "<script>alert('No se encontró el equipo.'); window.history.back();</script>";
        exit;
    }

    $equipo = $resultado->fetch_assoc();

    // Insertar en la tabla de reportes
    $descripcion = $equipo['Descripcion'];
    $id_lab = 1; // suponiendo que estás reportando LDR
    $marca = $equipo['Marca'];
    $modelo = $equipo['Modelo'];
    $numero_serie = $equipo['Numero_Serie'];
    $numero_itjmm = $equipo['Numero_ITJMM'];
    $mesa = $equipo['Mesa'];
    $numero_posicion = $equipo['Numero_Posicion'];
    $so = $equipo['SO'];
    $procesador = $equipo['Procesador'];
    $ram = $equipo['RAM'];
    $disco_duro = $equipo['Disco_Duro'];
    
    // Corregido: uso de variables reales en bind_param
    $insert = $conexion->prepare("INSERT INTO reportes 
        (Descripcion, ID_LAB, Marca, Modelo, Numero_Serie, Numero_ITJMM, Mesa, Numero_Posicion, SO, Procesador, RAM, Disco_Duro, Problema, Descipcion_Problema)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $insert->bind_param(
        "sissssssssssss",
        $descripcion,
        $id_lab,
        $marca,
        $modelo,
        $numero_serie,
        $numero_itjmm,
        $mesa,
        $numero_posicion,
        $so,
        $procesador,
        $ram,
        $disco_duro,
        $tipo_problema,
        $descripcion_problema
    );

    if ($insert->execute()) {
        echo "<script>alert('Reporte generado exitosamente.'); window.location.href='../../index.php';</script>";
    } else {
        echo "<script>alert('Error al generar el reporte: " . $insert->error . "'); window.history.back();</script>";
    }

} else {
    echo "<script>alert('Método de solicitud no válido.'); window.location='levantar_reporte.php';</script>";
}
?>
