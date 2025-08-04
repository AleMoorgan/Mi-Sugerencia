<?php
session_start(); // Esto debe ir al inicio sin espacios antes

// Mostrar errores para depurar (puedes quitarlo luego)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Datos de tu base de datos

// Conexión
$conn = new mysqli($host, $usuario, $contrasena, $bd);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibe datos del formulario y valida
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (!$username || !$password) {
    die("Faltan datos obligatorios.");
}

// Encripta contraseña
$hash = password_hash($password, PASSWORD_DEFAULT);

// Prepara y ejecuta la consulta
$sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación: " . $conn->error);
}

$stmt->bind_param("ss", $username, $hash);

if ($stmt->execute()) {
    $_SESSION['username'] = $username;

    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Registro Exitoso</title>
        <script>
            setTimeout(function() {
                window.location.href = 'dashboard.php';
            }, 3000);
        </script>
    </head>
    <body style='text-align: center; margin-top: 100px; font-family: sans-serif;'>
        <h2 style='color: hotpink;'>🩷¡Usuario agregado correctamente!🩷</h2>
        <p>Serás redirigido en unos segundos...</p>
    </body>
    </html>";
} else {
    echo "Error al guardar el usuario: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>