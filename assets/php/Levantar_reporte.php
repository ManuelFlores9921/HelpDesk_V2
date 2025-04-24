<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $numero_serie = $_POST['numero_serie'];
    $numero_inventario = $_POST['numero_inventario'];
    $descripcion = $_POST['descripcion'];

    // Lógica para guardar los datos del reporte en la base de datos o archivo (omitir aquí)

    // Configuración del correo electrónico
    $to = "destinatario@example.com";
    $subject = "Nuevo Reporte Realizado";
    $message = "Se ha realizado un nuevo reporte con la siguiente información:\n\n";
    $message .= "Marca: $marca\n";
    $message .= "Modelo: $modelo\n";
    $message .= "Número de Serie: $numero_serie\n";
    $message .= "Número de Inventario: $numero_inventario\n";
    $message .= "Descripción: $descripcion\n";

    // Enviar correo electrónico
    if (mail($to, $subject, $message)) {
        echo "Reporte enviado exitosamente y notificación por correo electrónico enviada.";
    } else {
        echo "Error al enviar el reporte o la notificación por correo electrónico.";
    }
}
?>
