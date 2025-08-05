<?php
$carpeta = "preguntas/";

$mensaje = "";

// Eliminar pregunta y sus respuestas
if (isset($_GET['eliminar'])) {
    $archivo = basename($_GET['eliminar']); // Sanitiza el nombre
    $ruta_pregunta = $carpeta . $archivo;
    $ruta_respuestas = $carpeta . str_replace('.txt', '_respuestas.txt', $archivo);

// Verifica si el archivo de la pregunta existe
if (file_exists($ruta_pregunta)) {
    // Si existe, lo elimina del sistema de archivos
    unlink($ruta_pregunta);
}

// Verifica si el archivo de respuestas asociado a la pregunta existe
if (file_exists($ruta_respuestas)) {
    // Si existe, también lo elimina
    unlink($ruta_respuestas);
}
    $mensaje = "Pregunta y sus respuestas eliminadas correctamente.";
}

// Eliminar una respuesta específica
if (isset($_GET['eliminar_respuesta'], $_GET['archivo'])) {
    $archivo = basename($_GET['archivo']);
    $indexEliminar = (int)$_GET['eliminar_respuesta'];

    $ruta_respuestas = $carpeta . str_replace('.txt', '_respuestas.txt', $archivo);
    if (file_exists($ruta_respuestas)) {
        $respuestas = file($ruta_respuestas, FILE_IGNORE_NEW_LINES);
        if (isset($respuestas[$indexEliminar])) {
            unset($respuestas[$indexEliminar]);
            // Reescribimos el archivo sin la respuesta eliminada
            file_put_contents($ruta_respuestas, implode("\n", $respuestas));
            $mensaje = "Respuesta eliminada correctamente.";
        }
    }
}

// Obtener el archivo de la pregunta a mostrar (si hay)
$mostrar_solo = isset($_GET['archivo']) ? basename($_GET['archivo']) : null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background: #f7f7f7;
        }
        h2 {
            text-align: center;
        }
        .mensaje {
            color: #8F8F8F;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            font-weight: bold;
        }
        .pregunta {
            background: white;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        .pregunta p {
            margin: 0;
            font-weight: bold;
        }
        .acciones {
            margin-top: 10px;
        }
        .acciones a {
            color: white;
            background-color: black;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9em;
            margin-right: 8px;
        }
        .respuesta {
            background: #eee;
            padding: 10px;
            border-radius: 6px;
            margin-top: 6px;
            position: relative;
        }
        .respuesta strong {
            font-weight: bold;
        }
        .respuesta a {
            position: absolute;
            right: 10px;
            top: 10px;
            color: red;
            font-weight: bold;
            text-decoration: none;
            font-size: 0.85em;
        }
        .volver {
            display: block;
            margin-top: 30px;
            text-align: center;
        }
        .volver a {
            background-color: black;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 8px;
        }
        .link-ver-todas {
            display: block;
            margin: 20px auto;
            width: fit-content;
            background: black;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
        }
        .link-ver-todas:hover {
            background: white;
        }
    </style>
</head>
<body>

<h2>Panel de Administración</h2>

<?php if ($mensaje): ?>
    <div class="mensaje"><?php echo $mensaje; ?></div>
<?php endif; ?>

<?php
if (is_dir($carpeta)) {
    $archivos = array_reverse(glob($carpeta . "*.txt"));
    // Filtrar para quitar archivos de respuestas
    $preguntas = array_filter($archivos, function($archivo) {
        return !str_contains($archivo, '_respuestas.txt');
    });

    if (empty($preguntas)) {
        echo "<p style='text-align:center;'>No hay preguntas disponibles.</p>";
    } else {
        foreach ($preguntas as $archivo) {
            $nombre = basename($archivo);

            // Si se pidió mostrar solo una pregunta y no es esta, saltar
            if ($mostrar_solo !== null && $mostrar_solo !== $nombre) {
                continue;
            }

            // Leer primera línea de la pregunta
            $linea = file($archivo)[0] ?? 'Pregunta sin texto';
            $linea_html = htmlspecialchars($linea);

            echo "<div class='pregunta'>";
            echo "<p>$linea_html</p>";

            // Botón para eliminar la pregunta completa (pregunta + respuestas)
            echo "<div class='acciones'>";
            echo "<a href='?eliminar=$nombre' onclick='return confirm(\"¿Eliminar esta pregunta y todas sus respuestas?\")'>Eliminar Pregunta</a>";
            echo "</div>";

            // Mostrar respuestas
            $archivo_respuestas = str_replace('.txt', '_respuestas.txt', $nombre);
            $ruta_respuestas = $carpeta . $archivo_respuestas;
            if (file_exists($ruta_respuestas)) {
                $respuestas = file($ruta_respuestas, FILE_IGNORE_NEW_LINES);
                if (count($respuestas) > 0) {
                    foreach ($respuestas as $index => $respuesta) {
                        $partes = explode("|", $respuesta, 2);
                        $usuario = htmlspecialchars($partes[0] ?? 'Anónimo');
                        $texto = htmlspecialchars($partes[1] ?? '');
                        echo "<div class='respuesta'>";
                        echo "<strong>$usuario:</strong> $texto ";
                        echo "<a href='?eliminar_respuesta=$index&archivo=$nombre' onclick='return confirm(\"¿Eliminar esta respuesta?\")' title='Eliminar respuesta'>X</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='respuesta'><em>No hay respuestas aún.</em></div>";
                }
            } else {
                echo "<div class='respuesta'><em>No hay respuestas aún.</em></div>";
            }

            echo "</div>"; // cierre .pregunta
        }

        // Si mostramos solo una pregunta, añadir link para volver a todas
        if ($mostrar_solo !== null) {
            echo "<a href='gest_prere.php' class='link-ver-todas'>Ver todas las preguntas</a>";
        }
    }
} else {
    echo "<p style='text-align:center;'>No existe la carpeta de preguntas.</p>";
}
?>

<div class="volver">
    <a href="panel_admin.php">Volver al panel principal</a>
</div>

</body>
</html>