<?php
session_start();
require_once 'conexion.php';
require_once '../email/Exception.php';
require_once '../email/PHPMailer.php';
require_once '../email/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['id_reporte']) || empty($_POST['tecnico'])) {
        echo "<script>alert('Faltan datos para asignar el técnico.'); window.history.back();</script>";
        exit;
    }

    $id_reporte = $_POST['id_reporte'];
    $id_tecnico = $_POST['tecnico'];

    // Obtener datos del técnico
    $stmt = $conexion->prepare("SELECT Nombre, Correo FROM usuarios WHERE idusuarios = ?");
    $stmt->bind_param("i", $id_tecnico);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        echo "<script>alert('Técnico no encontrado.'); window.history.back();</script>";
        exit;
    }

    $tecnico_data = $resultado->fetch_assoc();
    $tecnico = $tecnico_data['Nombre'];
    $tecnico_email = $tecnico_data['Correo'];

    // Actualizar reporte
    $stmt_update = $conexion->prepare("UPDATE reportes SET Tecnico = ? WHERE ID_Reporte = ?");
    $stmt_update->bind_param("si", $tecnico, $id_reporte);

    if ($stmt_update->execute()) {
        // Enviar correo al técnico
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'za19011237@zapopan.tecmm.edu.mx'; // Remitente
            $mail->Password   = 'naem gfre jlsy ujfe';              // Contraseña de app (NO compartas esto públicamente)
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Remitente y destinatario
            $mail->setFrom('za19011237@zapopan.tecmm.edu.mx', 'HELPDESK');
            $mail->addAddress($tecnico_email, $tecnico);

            // Incrustar imagen
            $mail->addEmbeddedImage('../../img/Logos/tsj_logo_inferior.png', 'header_cid');

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = 'Se te ha asignado un nuevo ticket de servicio';

            $mail->Body = "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <title>Asignación de Ticket</title>
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap');
                    * { box-sizing: border-box; font-family: 'Oswald', sans-serif; margin: 0; padding: 0; }
                    .body_container { background: #00A29A; padding: 20px; width: 100%; }
                    .title_container h1 { color: #FFFFFF; font-size: 2.5rem; padding: 10px; }
                    .body h3, .body p, .body span { color: #FFFFFF; padding: 10px; font-size: 1.2rem; }
                    .legend { display: flex; justify-content: center; padding: 10px; gap: 10px; color: #FFFFFF; }
                    .image_container img { width: 100%; height: auto; }
                </style>
            </head>
            <body>
                <div class='body_container'>
                    <div class='title_container'>
                        <h1>Asignación de Ticket de Servicio</h1>
                    </div>
                    <div class='body'>
                        <h3>Hola {$tecnico},</h3>
                        <p>Se te ha asignado un nuevo ticket de servicio con el ID <strong>{$id_reporte}</strong>.</p>
                        <p>Por favor, ingresa a la plataforma para revisar los detalles y comenzar con la atención del mismo.</p>
                        <span>Si tienes dudas sobre este ticket, comunícate con el área de soporte técnico.</span>
                        <div class='legend'>
                            <span>*******************</span>
                            <span style='font-weight: bold;'>ESTE CORREO ES SOLO INFORMATIVO</span>
                            <span>*******************</span>
                        </div>
                    </div>
                    <div class='image_container'>
                        <img src='cid:header_cid'>
                    </div>
                </div>
            </body>
            </html>";

            $mail->send();
            echo "<script>alert('Técnico asignado y notificación enviada.'); window.location.href='../../Reportes.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Técnico asignado, pero ocurrió un error al enviar el correo: {$mail->ErrorInfo}'); window.location.href='../../Reportes.php';</script>";
        }
    } else {
        echo "<script>alert('Error al asignar el técnico: " . $stmt_update->error . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Método no permitido.'); window.location.href='../../Reportes.php';</script>";
}
