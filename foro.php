<?php
$carpeta = "preguntas/";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['pregunta'])) {
    if (!is_dir($carpeta)) {
        mkdir($carpeta);
    }

    $id = time(); // ID único basado en timestamp
    $archivo = $carpeta . $id . ".txt";
    $contenido = "Pregunta: " . trim($_POST['pregunta']) . "\n";

    file_put_contents($archivo, $contenido);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Foro</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background-image: url('https://i.pinimg.com/736x/92/e3/e8/92e3e834071c4c798555059a065bb665.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: repeat;
            color: #000;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        h2 {
            font-size: 50px;
            text-align: center;
            color: black;
            margin-top: 0;
        }

        h3 {
            font-size: 20px;
            text-align: center;
            color: black;
            margin-top: 0;
        }

        hr.black-line {
            border: none;
            height: 5px;
            background-color: black;
            margin: 40px 0;
        }

        .container {
            display: flex;
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }


        /* Columna izquierda */
        .left {
            flex: 2;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            max-height: 80vh;
        }

        /* Columna derecha */
        .right {
            flex: 1;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: 80vh;
        }

        textarea {
            width: 95%;
            resize: vertical;
            padding: 10px;
            font-size: 1.1em;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-family: sans-serif;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: hotpink;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1.1em;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #c7154b;
        }

        .preguntas a {
            color: hotpink;
            font-weight: bold;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }

        .preguntas a:hover {
            text-decoration: underline;
        }

        .right img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 10px;
            object-fit: contain;
            box-shadow: 0 0 10px #888;
        }

        @media (max-width: 800px) {
            .container {
                flex-direction: column;
            }
            .right {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

    <h2>๋ ࣭ ⭑๋ ࣭ ⭑Foro ࣭ ⭑๋ ࣭ ⭑</h2>
    <h3>Éste foro es para dudas de MATEMÁTICAS</h3>
        <hr class="black-line">

    <div class="container">
        <div class="left">
            <!-- Formulario para enviar una pregunta -->
            <form method="post">
                <textarea name="pregunta" rows="4" placeholder="Escribe tu pregunta..." required></textarea>
                <input type="submit" value="Publicar pregunta" />
            </form>

            <hr />

            <h3>Preguntas:</h3>
            <div class="preguntas">
                <?php
                if (is_dir($carpeta)) {
$archivos = array_reverse(glob($carpeta . "*.txt"));
$preguntas = array_filter($archivos, function($archivo) {
    return !str_contains($archivo, '_respuestas.txt');
});

if (count($preguntas) === 0) {
    echo "<p>Aún no hay preguntas.</p>";
} else {
    foreach ($preguntas as $archivo) {
        $nombre = basename($archivo);
        $linea = file($archivo)[0] ?? 'Pregunta sin texto';
        echo "<a href='ver.php?archivo=$nombre'>" . htmlspecialchars($linea) . "</a>";
    }
}
                } else {
                    echo "<p>Aún no hay preguntas.</p>";
                }
                ?>
            </div>
        </div>

<?php
// Leer la URL desde el archivo plano
$archivo_imagen = 'imagen_foro.txt';
$imagen_foro = file_exists($archivo_imagen) ? trim(file_get_contents($archivo_imagen)) : '';
?>

<div class="right">
    <?php if (!empty($imagen_foro)): ?>
        <img src="<?php echo htmlspecialchars($imagen_foro); ?>" alt="Imagen del foro" style="max-width:100%; border-radius:10px;">
    <?php else: ?>
        <p style="color:white;">No hay imagen configurada para el foro.</p>
    <?php endif; ?>
</div>
</div> <!-- Cierre de .container -->

<!-- Botón Volver debajo de todo -->
<div style="text-align: center; margin-top: 40px;">
    <a href="dashboard.php" style="
        display: inline-block;
        background-color: black;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1em;
    ">Volver</a>
</div>

</body>
</html>