<?php
session_start();
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true) {
    header("Location: Login.php");
    exit();
}

require 'conexion.php';
require_once '../email/Exception.php';
require_once '../email/PHPMailer.php';
require_once '../email/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_reporte = $_POST['id_reporte'] ?? null;
    $nuevo_estatus = $_POST['nuevo_estatus'] ?? null;
    $usuario_actual = $_SESSION['nombre'] ?? 'Usuario desconocido';

    if ($id_reporte && $nuevo_estatus) {
        // Si es "Pendiente", verificar si hay técnico asignado
        if ($nuevo_estatus === "Pendiente") {
            // Obtener el técnico actual
            $stmt_tecnico_actual = $conexion->prepare("SELECT u.Correo, u.Nombre 
                                                        FROM reportes r 
                                                        INNER JOIN usuarios u 
                                                        ON CONVERT(r.Tecnico USING utf8mb4) COLLATE utf8mb4_spanish_ci = 
                                                        CONVERT(u.Nombre USING utf8mb4) COLLATE utf8mb4_spanish_ci 
                                                        WHERE r.ID_Reporte = ? AND r.Tecnico != 'Sin Asignar'");
            $stmt_tecnico_actual->bind_param("i", $id_reporte);
            $stmt_tecnico_actual->execute();
            $resultado_tecnico = $stmt_tecnico_actual->get_result();

            if ($resultado_tecnico && $resultado_tecnico->num_rows > 0) {
                $tecnico = $resultado_tecnico->fetch_assoc();
                $correo = $tecnico['Correo'];
                $nombre_tecnico = $tecnico['Nombre'];

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'za19011237@zapopan.tecmm.edu.mx';
                    $mail->Password   = 'naem gfre jlsy ujfe';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;

                    $mail->setFrom('za19011237@zapopan.tecmm.edu.mx', 'Sistema de Reportes ITJMM');
                    $mail->addAddress($correo, $nombre_tecnico);

                    // Incrustar imagen
                    $mail->addEmbeddedImage('../../img/Logos/tsj_logo_inferior.png', 'header_cid');

                    $mail->isHTML(true);
                    $mail->Subject = "Notificación de desasignación de reporte";
                    $mail->Body = "
                    <!DOCTYPE html>
                        <html lang='es'>
                        <head>
                            <style>
                                body { font-family: 'Oswald', sans-serif; background-color: #f44336; padding: 20px; color: #fff; }
                                .contenido { background-color: #c62828; padding: 20px; border-radius: 10px; }
                                .footer { margin-top: 20px; font-size: 0.9rem; text-align: center; }
                            </style>
                        </head>
                        <body>
                            <div class='contenido'>
                                <h2>Hola {$nombre_tecnico},</h2>
                                <p>Te informamos que la orden del reporte con ID <strong>{$id_reporte}</strong> ha sido retirada de tu asignación.</p>
                                <p>Este cambio fue realizado por el usuario <strong>{$_SESSION['Nombre']}</strong> al actualizar el estatus a <strong>Pendiente</strong>.</p>
                            </div>
                            <div class='footer'>
                                <p>*******************</p>
                                <p><strong>ESTE CORREO ES SOLO INFORMATIVO</strong></p>
                                <p>*******************</p>
                            </div>
                            <div class='image_container' style='text-align: center; margin-top: 20px;'>
                                <img src='cid:header_cid' style='width: 200px; height: auto;'>
                            </div>
                        </body>
                    </html>
                    ";

                    $mail->send();
                } catch (Exception $e) {
                    error_log("No se pudo enviar el correo de desasignación: {$mail->ErrorInfo}");
                }
            }
            $stmt_tecnico_actual->close();

            // Desasignar técnico
            $stmt = $conexion->prepare("UPDATE reportes SET Estatus = ?, Tecnico = 'Sin Asignar' WHERE ID_Reporte = ?");
            $stmt->bind_param("si", $nuevo_estatus, $id_reporte);
        } else {
            // Solo actualizar estatus
            $stmt = $conexion->prepare("UPDATE reportes SET Estatus = ? WHERE ID_Reporte = ?");
            $stmt->bind_param("si", $nuevo_estatus, $id_reporte);
        }

        if ($stmt->execute()) {
            // Enviar correo si el estatus es "En Revisión"
            if ($nuevo_estatus === "En Revision") {
                $stmt_tecnico = $conexion->prepare("SELECT u.Correo, u.Nombre 
                                                    FROM reportes r 
                                                    INNER JOIN usuarios u ON r.Tecnico = u.Nombre 
                                                    WHERE r.ID_Reporte = ?");
                $stmt_tecnico->bind_param("i", $id_reporte);
                $stmt_tecnico->execute();
                $resultado = $stmt_tecnico->get_result();

                if ($resultado && $resultado->num_rows > 0) {
                    $tecnico = $resultado->fetch_assoc();
                    $correo = $tecnico['Correo'];
                    $nombre_tecnico = $tecnico['Nombre'];

                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'za19011237@zapopan.tecmm.edu.mx';
                        $mail->Password   = 'naem gfre jlsy ujfe';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port       = 587;

                        $mail->setFrom('za19011237@zapopan.tecmm.edu.mx', 'Sistema de Reportes ITJMM');
                        $mail->addAddress($correo, $nombre_tecnico);
                        $mail->addEmbeddedImage('../../img/Logos/tsj_logo_inferior.png', 'header_cid');

                        $mail->isHTML(true);
                        $mail->Subject = "Notificación de estatus: En revisión";
                        $mail->Body = "
                        <!DOCTYPE html>
                        <html lang='es'>
                            <head>
                                <style>
                                    body { font-family: 'Oswald', sans-serif; background-color: #00A29A; padding: 20px; color: #fff; }
                                    .contenido { background-color: #007c76; padding: 20px; border-radius: 10px; }
                                    .footer { margin-top: 20px; font-size: 0.9rem; text-align: center; }
                                </style>
                            </head>
                            <body>
                                <div class='contenido'>
                                    <h2>Hola {$nombre_tecnico},</h2>
                                    <p>Te informamos que el estatus del reporte con ID <strong>{$id_reporte}</strong> ha cambiado a <strong>En Revisión</strong>.</p>
                                    <p>Por favor, revisa el sistema para iniciar el proceso correspondiente.</p>
                                </div>
                                <div class='footer'>
                                    <p>*******************</p>
                                    <p><strong>ESTE CORREO ES SOLO INFORMATIVO</strong></p>
                                    <p>*******************</p>
                                </div>
                                <div class='image_container' style='text-align: center; margin-top: 20px;'>
                                    <img src='cid:header_cid' style='width: 200px; height: auto;'>
                                </div>

                            </body>
                        </html>
                        ";

                        $mail->send();
                    } catch (Exception $e) {
                        error_log("No se pudo enviar el correo: {$mail->ErrorInfo}");
                    }
                }
                $stmt_tecnico->close();
            }

            // Si estatus es "Completado", mostrar mensaje con nombre del usuario
            if ($nuevo_estatus === "Completado") {
                // Obtener técnico asignado
                $stmt_tecnico = $conexion->prepare("SELECT u.Correo, u.Nombre 
                                                    FROM reportes r 
                                                    INNER JOIN usuarios u 
                                                    ON CONVERT(r.Tecnico USING utf8mb4) COLLATE utf8mb4_spanish_ci = 
                                                       CONVERT(u.Nombre USING utf8mb4) COLLATE utf8mb4_spanish_ci 
                                                    WHERE r.ID_Reporte = ?");
                $stmt_tecnico->bind_param("i", $id_reporte);
                $stmt_tecnico->execute();
                $resultado = $stmt_tecnico->get_result();
            
                if ($resultado && $resultado->num_rows > 0) {
                    $tecnico = $resultado->fetch_assoc();
                    $correo = $tecnico['Correo'];
                    $nombre_tecnico = $tecnico['Nombre'];
            
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'za19011237@zapopan.tecmm.edu.mx';
                        $mail->Password   = 'naem gfre jlsy ujfe';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port       = 587;
            
                        $mail->setFrom('za19011237@zapopan.tecmm.edu.mx', 'Sistema de Reportes ITJMM');
                        $mail->addAddress($correo, $nombre_tecnico);
                        $mail->addEmbeddedImage('../../img/Logos/tsj_logo_inferior.png', 'header_cid');
            
                        $mail->isHTML(true);
                        $mail->Subject = "Reporte finalizado";
                        $mail->Body = "
                        <!DOCTYPE html>
                        <html lang='es'>
                            <head>
                                <style>
                                    body { font-family: 'Oswald', sans-serif; background-color: #4CAF50; padding: 20px; color: #fff; }
                                    .contenido { background-color: #388E3C; padding: 20px; border-radius: 10px; }
                                    .footer { margin-top: 20px; font-size: 0.9rem; text-align: center; }
                                </style>
                            </head>
                            <body>
                                <div class='contenido'>
                                    <h2>Hola {$nombre_tecnico},</h2>
                                    <p>Te informamos que el reporte con ID <strong>{$id_reporte}</strong> ha sido marcado como <strong>Completado</strong>.</p>
                                    <p>Este cambio fue realizado por el usuario <strong>{$_SESSION['Nombre']}</strong>.</p>
                                </div>
                                <div class='footer'>
                                    <p>*******************</p>
                                    <p><strong>ESTE CORREO ES SOLO INFORMATIVO</strong></p>
                                    <p>*******************</p>
                                </div>
                                <div class='image_container' style='text-align: center; margin-top: 20px;'>
                                    <img src='cid:header_cid' style='width: 200px; height: auto;'>
                                </div>
                            </body>
                        </html>
                        ";
            
                        $mail->send();
                    } catch (Exception $e) {
                        error_log("No se pudo enviar el correo de finalización: {$mail->ErrorInfo}");
                    }
                }
                $stmt_tecnico->close();
            
                echo "<script>alert('¡El reporte con ID {$id_reporte} ha sido marcado como completado por {$usuario_actual}!'); window.location.href='../../Reportes.php';</script>";
                exit();
            }            

            echo "<script>alert('Estatus actualizado correctamente.'); window.location.href='../../Reportes.php';</script>";
            exit();
        } else {
            echo "Error al actualizar el estatus: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Datos incompletos para actualizar.";
    }
} else {
    echo "Acceso no permitido.";
}
