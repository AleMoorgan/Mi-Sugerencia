<?php
session_start();
if (!isset($_SESSION['es_admin'])) {
    header("Location: admin.php");
    exit();
}

$archivo = 'noticia.json';

// Leer la noticia actual
$noticia = json_decode(file_get_contents($archivo), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_noticia = [
        'titulo' => $_POST['titulo'],
        'link' => $_POST['link'],
        'imagen' => $_POST['imagen']
    ];

    file_put_contents($archivo, json_encode($nueva_noticia, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Noticia</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f0f0f0;
            padding: 40px;
        }

        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background: black;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #444;
        }
    </style>
</head>
<body>

    <h2>Editar Noticia HK NEWS</h2>

    <form method="POST">
        <label for="titulo">Título:</label>
        <textarea name="titulo" id="titulo" required><?= htmlspecialchars($noticia['titulo']) ?></textarea>

        <label for="link">Enlace:</label>
        <input type="text" name="link" id="link" value="<?= htmlspecialchars($noticia['link']) ?>" required>

        <label for="imagen">URL de imagen:</label>
        <input type="text" name="imagen" id="imagen" value="<?= htmlspecialchars($noticia['imagen']) ?>" required>

        <button type="submit">Guardar cambios</button>
    </form>

</body>
</html>