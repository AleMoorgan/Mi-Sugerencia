<?php
session_start();

// Datos de conexión (modifica con tus datos)

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Consulta SQL para obtener libros
$sql = "SELECT id, titulo, autor, year, calif, resena FROM libros";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Biblioteca</title>
    <a href="dashboard.php" style="
    display: inline-block;
    background-color: black;
    color: white;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 1em;
    margin-bottom: 20px;
">Volver</a>
    <style>
        body {
            font-family: sans-serif;
            background-color: #fafafa;
            padding: 20px;
                        margin: 0;
            font-family: sans-serif;
            background-image: url('https://i.pinimg.com/736x/62/82/fd/6282fd6d0289cc5783bfad31b0923148.jpg'); /* Fondo */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            color: #000;
        h1{
            font-size: 50px;
            text-align: center;
            color: black;
        }

        }
        table {
            width: 90%;
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
            background-color: white;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        td a {
    color: hotpink; /* Rosa */
    text-decoration: none;
    font-weight: bold;
}

td a:hover {
    text-decoration: underline;
}

        th {
            background-color: black;
            color: white;
        }
        tr:nth-child(even) {
            background-color: white;
        }
    </style>
</head>
<body>
    <h1>Biblioteca</h1>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table>";
        echo "<thead><tr><th>Título</th><th>Autor</th><th>Año</th><th>Calificación</th><th>Reseña</th></tr></thead>";
        echo "<tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='libro.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['titulo']) . "</a></td>";
            echo "<td>" . htmlspecialchars($row['autor']) . "</td>";
            echo "<td>" . htmlspecialchars($row['year']) . "</td>";
            echo "<td>" . htmlspecialchars($row['calif']) . "</td>";
            echo "<td>" . htmlspecialchars($row['resena']) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No hay libros disponibles.</p>";
    }

    $conn->close();
    ?>
</body>
</html>