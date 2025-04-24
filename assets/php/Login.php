<?php
require_once 'conexion.php';

session_start();
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $numEmp = $_POST['num_emp'];

    // Prepare and execute the SQL statement
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE Correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['Numero_Empleado'] == $numEmp) {
            // Valid credentials
            $_SESSION['id'] = $row['idusuarios'];
            $_SESSION['Nombre'] = $row['Nombre'];
            $_SESSION['rol'] = $row['Puesto'];
            $_SESSION['isLogged'] = true;

            header("Location: ../../index.php");
            exit();
        } else {
            // Invalid credentials
            echo "Numero de empleado invalido.";
        }
    } else {
        // Invalid credentials
        echo "Correo Invalido.";
    }

    // Close the statement and connection
    $stmt->close();
    $conexion->close();
}