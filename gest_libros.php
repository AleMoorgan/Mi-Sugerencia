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
    <title>Gestión de Libros</title>
    <style>
body {
    margin: 0;
    font-family: sans-serif;
    background-image: url('https://i.pinimg.com/736x/a9/3b/04/a93b0415c782a957930362f4e3b5d0c6.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    color: #fff; /* Cambiado a blanco para mejor contraste */
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
    background: rgba(0, 0, 0, 0.6); /* Ajusta 0.6 para más/menos oscuridad */
    z-index: -1;
}
        h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 30px;
        }
        form {
            background-color: rgba(0,0,0,0.7);
            padding: 20px;
            border-radius: 12px;
            width: 78%;
            margin: 0 auto 40px auto;
            box-shadow: 0 0 15px #fff;
        }
        form input, form textarea {
            width: 60%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: none;
            font-size: 1em;
        }
        form button {
            background-color: #fff;
            color: #000;
            font-weight: bold;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }
        form button:hover {
            background-color: #ddd;
        }
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: rgba(0,0,0,0.7);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 15px #fff;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #444;
            color: #eee;
        }
        th {
            background-color: #222;
        }
        tr:hover {
            background-color: #333;
        }
        .btn-eliminar {
            background-color: black;
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-eliminar:hover {
            background-color: white;
        }
        .volv {
            text-align: center;
            margin-top: 30px;
        }
        .volv a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            background-color: black;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .logout a:hover {
            background-color: white;
        }
    </style>
</head>

<?php if (isset($_GET['exito'])): ?>
    <p style="text-align:center; color:hotpink; font-weight:bold;">📕Libro agregado correctamente.</p>
<?php endif; ?>

<body>

<h2>Gestión de Libros</h2>

<!-- Formulario para agregar libro -->
<form action="procesar_agregar.php" method="POST">
    <input type="text" name="titulo" placeholder="Título" required>
    <input type="text" name="autor" placeholder="Autor" required>
    <input type="number" name="year" placeholder="Año" min="0" max="2100" required>
    <input type="number" name="calif" placeholder="Calificación" min="0" max="10" step="0.1" required>
    <textarea name="resena" placeholder="Reseña" rows="4" required></textarea>

    <input type="file" name="imagen" accept="image/*" required>

    <button type="submit">Agregar libro</button>
</form>

<!-- Tabla de libros -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Año</th>
            <th>Calificación</th>
            <th>Reseña</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while($libro = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($libro['id']) ?></td>
            <td><?= htmlspecialchars($libro['titulo']) ?></td>
            <td><?= htmlspecialchars($libro['autor']) ?></td>
            <td><?= htmlspecialchars($libro['year']) ?></td>
            <td><?= htmlspecialchars($libro['calif']) ?></td>
            <td style="max-width: 300px; text-align: left;"><?= nl2br(htmlspecialchars($libro['resena'])) ?></td>
            <td>
                <form action="procesar_eliminar.php" method="POST" onsubmit="return confirm('¿Eliminar libro ID <?= $libro['id'] ?>?');">
                    <input type="hidden" name="id" value="<?= $libro['id'] ?>">
                    <button type="submit" class="btn-eliminar">Eliminar</button>
                </form>
                <a href="editar.php?id=<?php echo $libro['id']; ?>" style="color: white;">Editar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div class="volv">
    <a href="panel_admin.php">Volver</a>
</div>

</body>
</html>