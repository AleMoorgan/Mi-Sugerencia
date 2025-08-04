<?php
session_start();
if (!isset($_SESSION['es_admin'])) {
    header("Location: admin.php");
    exit();
}
include 'db.php';

$id = intval($_POST['id'] ?? 0);
if ($id > 0) {
    $stmt = $conexion->prepare("DELETE FROM libros WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: panel_admin.php");
exit();