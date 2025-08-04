<?php
session_start();
include 'dbb.php'; // Asegúrate de que esta conexión sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta segura solo por el nombre de usuario
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña usando password_verify
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location.href='index.html';</script>";
    }

    $stmt->close();
    $conexion->close();
}
?>