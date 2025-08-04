<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['es_admin'])) {
    header("Location: admin.php");
    exit();
}

include 'db.php'; // conexión a la base de datos

// Obtener todos los libros para mostrar
$result = $conexion->query("SELECT * FROM libros");
if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Gestión de Libros</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background-image: url('https://i.pinimg.com/736x/a9/3b/04/a93b0415c782a957930362f4e3b5d0c6.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            color: #fff;
            position: relative;
            z-index: 0;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        h2 {
            text-align: center;
            color: #fff;
            margin-top: 30px;
            margin-bottom: 40px;
        }

        .admin-menu {
            background-color: white;
            color: black;
            padding: 30px 40px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            min-width: 220px;
        }

        .admin-menu a {
            color: black;
            text-decoration: none;
            margin: 12px 0;
            font-size: 20px;
            text-align: center;
            padding: 10px 20px;
            width: 100%;
            border-radius: 6px;
            transition: background-color 0.3s, color 0.3s;
        }

        .admin-menu a:hover {
            background-color: black;
            color: white;
        }

        .logout {
            text-align: center;
            margin-top: 20px;
            font-size: 20px;
        }

        .logout a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            background-color: black;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
        }

        .logout a:hover {
            background-color: white;
            color: black;
        }
    </style>
</head>
<body>

    <h2>PANEL DE ADMINISTRADOR</h2>

    <nav class="admin-menu">
        <a href="gest_libros.php">Gestión de libros</a>
        <a href="gest_prere.php">Preguntas y respuestas</a>
        <a href="meme.php">Meme</a>
        <a href="hknews.php">HM NEWS</a>
    </nav>

</body>

    <div class="logout">
        <a href="dashboard.php">Cerrar sesión admin</a>
    </div>

</html>