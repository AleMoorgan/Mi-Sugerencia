<?php
session_start();

// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Validación de sesión
if (!isset($_SESSION['es_admin'])) {
    header("Location: admin.php");
    exit();
}

include 'db.php';

// Recoger datos del formulario
$titulo = $_POST['titulo'] ?? '';
$autor = $_POST['autor'] ?? '';
$year = intval($_POST['year'] ?? 0);
$calif = floatval($_POST['calif'] ?? 0);
$resena = $_POST['resena'] ?? '';

// Validar entrada
if ($titulo && $autor && $year > 0 && $calif >= 0 && $resena) {
    // CORRECCIÓN: usar $conexion
    $stmt = $conexion->prepare("INSERT INTO libros (titulo, autor, year, calif, resena) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssids", $titulo, $autor, $year, $calif, $resena);
        if ($stmt->execute()) {
            header("Location: panel_admin.php?exito=1");
            exit();
        } else {
            die("❌ Error al ejecutar la inserción: " . $stmt->error);
        }
    } else {
        die("❌ Error al preparar la consulta: " . $conexion->error);
    }
} else {
    die("❌ Todos los campos son obligatorios.");
}