<?php
// Incluir el archivo de conexión a la base de datos
include("conexion.php");
require_once("../../logs/loger.php");

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escapar los datos para evitar inyección SQL
    $Nombre = mysqli_real_escape_string($conexion, $_POST['Nombre']);
    Logger::info("Nombre recibido: $Nombre");

    $Correo = mysqli_real_escape_string($conexion, $_POST['Correo']);
    Logger::info("Correo recibido: $Correo");

    $numEmp = mysqli_real_escape_string($conexion, $_POST['num_emp']);
    Logger::info("Numero de empleado recibido: $numEmp");

    $Puesto = mysqli_real_escape_string($conexion, $_POST['Puesto']);
    Logger::info("Puesto recibido: $Puesto");

    // Verificar si el correo ya está registrado
    $sqluser = "SELECT idusuarios FROM usuarios WHERE Correo = '$Correo'";
    $resultadouser = $conexion->query($sqluser);

    if (!$resultadouser) {
        // Manejo de error en la consulta SELECT
        die("Error en la consulta SELECT: " . $conexion->error);
        Logger::info("Error en la consulta SELECT: " . $conexion->error);
    }

    if ($resultadouser->num_rows > 0) {
        echo "<script>
                alert('El correo ya está registrado');
                window.location = '../../Crear_Cuenta.html';
            </script>";
    } else {
        echo "El correo no está registrado, procediendo con el registro...<br>";

        // Usar password_hash para almacenar contraseñas de forma segura
        $numEmpHash = password_hash($numEmp, PASSWORD_BCRYPT);
        echo "Numero de Empleado encriptado correctamente.<br>";

        // Insertar el nuevo usuario en la base de datos
        $sqlusuario = "INSERT INTO usuarios (Nombre, Correo, Numero_Empleado, Puesto)
                       VALUES ('$Nombre', '$Correo', '$numEmpHash', '$Puesto')";
        $resultadousuario = $conexion->query($sqlusuario);

        if ($resultadousuario) {
            header("Location: ../../index.php");
            echo "<script>
                    console.log('Exito al registrar el usuario');
                </script>";  
        } else {
            header("Location: ../../index.php");
            // Manejo de error en la consulta INSERT
            echo "<script>
                    console.log('Error al registrar el usuario: " . $conexion->error . "');
                </script>";  
        }
    }
}else{
    Logger::info("No se envió el formulario");
}
?>