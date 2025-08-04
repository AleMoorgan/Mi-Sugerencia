<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión para ver y responder preguntas.";
    exit;
}

$carpeta = "preguntas/";
$id = $_GET['archivo'] ?? null;

if (!$id || !preg_match('/^\d+\.txt$/', $id)) {
    echo "Archivo inválido.";
    exit;
}

$rutaPregunta = $carpeta . $id;
$rutaRespuestas = $carpeta . str_replace('.txt', '_respuestas.txt', $id);

// Guardar respuesta si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['respuesta'])) {
    $usuario = $_SESSION['usuario'];
    $respuesta = trim($_POST['respuesta']);

    // Leer respuestas existentes para obtener último ID
    $lineasRespuestas = file_exists($rutaRespuestas) ? file($rutaRespuestas, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
    $ultimoId = 0;
    if (count($lineasRespuestas) > 0) {
        $ultimaLinea = end($lineasRespuestas);
        $partesUltima = explode('|', $ultimaLinea, 3);
        $ultimoId = (int)$partesUltima[0];
    }

    $nuevoId = $ultimoId + 1;

    // Guardar respuesta con formato id|usuario|respuesta
    $linea = $nuevoId . "|" . $usuario . "|" . str_replace(["\r", "\n"], ['',''], $respuesta) . "\n";
    file_put_contents($rutaRespuestas, $linea, FILE_APPEND);
    header("Location: ver.php?archivo=" . urlencode($id));
    exit;
}

// Leer la pregunta
if (!file_exists($rutaPregunta)) {
    echo "La pregunta no existe.";
    exit;
}

$contenidoPregunta = file($rutaPregunta)[0] ?? "Pregunta vacía";

// Leer respuestas
$respuestas = [];
if (file_exists($rutaRespuestas)) {
    $respuestas = file($rutaRespuestas, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Ver Pregunta</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background-image: url('https://i.pinimg.com/736x/ed/0b/ce/ed0bce972798dc48566eeb118343771c.jpg');
            max-width: 700px;
            margin: auto;
        }
        h2 {
            color: black;
        }
        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            font-size: 1.1em;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        input[type="submit"] {
            margin-top: 10px;
            background-color: hotpink;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
        }
        input[type="submit"]:hover {
            background-color: #c7154b;
        }
        .respuesta {
            background: white;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            position: relative;
        }
        .usuario {
            font-weight: bold;
            color: #e91e63;
            margin-bottom: 5px;
        }
        .btn-borrar {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

    <h2><?= htmlspecialchars($contenidoPregunta) ?></h2>

    <form method="post">
        <label for="respuesta">Escribe tu respuesta:</label><br />
        <textarea id="respuesta" name="respuesta" required></textarea><br />
        <input type="submit" value="Publicar respuesta" />
    </form>

    <hr style="border: none; height: 5px; background-color: black; margin-top: 40px;">

    <h3>Respuestas:</h3>

    <?php if (count($respuestas) === 0): ?>
        <p>Aún no hay respuestas.</p>
    <?php else: ?>
        <?php foreach ($respuestas as $linea): 
            list($idResp, $usuarioResp, $textoResp) = explode('|', $linea, 3);
        ?>
            <div class="respuesta">
                <div class="usuario"><?= htmlspecialchars($usuarioResp) ?></div>
                <div class="texto"><?= nl2br(htmlspecialchars($textoResp)) ?></div>
                <?php if ($_SESSION['usuario'] === $usuarioResp): ?>
                    <form method="post" action="borrar_respuesta.php" style="display:inline;">
                        <input type="hidden" name="archivo" value="<?= htmlspecialchars($id) ?>">
                        <input type="hidden" name="idRespuesta" value="<?= htmlspecialchars($idResp) ?>">
                        <input type="submit" value="Borrar" class="btn-borrar" onclick="return confirm('¿Seguro que quieres borrar esta respuesta?');">
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="foro.php" style="
        display: inline-block;
        background-color: black;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1em;
        margin-bottom: 20px;
    ">Volver</a>

</body>
</html>