<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión para borrar respuestas.";
    exit;
}

$archivo = $_POST['archivo'] ?? null;
$idRespuesta = $_POST['idRespuesta'] ?? null;

if (!$archivo || !preg_match('/^\d+\.txt$/', $archivo) || !$idRespuesta || !is_numeric($idRespuesta)) {
    echo "Datos inválidos.";
    exit;
}

$carpeta = "preguntas/";
$rutaRespuestas = $carpeta . str_replace('.txt', '_respuestas.txt', $archivo);

if (!file_exists($rutaRespuestas)) {
    echo "Archivo de respuestas no encontrado.";
    exit;
}

$lineas = file($rutaRespuestas, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$nuevasLineas = [];

foreach ($lineas as $linea) {
    list($id, $usuarioResp, $textoResp) = explode('|', $linea, 3);

    if ($id == $idRespuesta) {
        // Solo el autor puede borrar su respuesta
        if ($usuarioResp !== $_SESSION['usuario']) {
            echo "No tienes permiso para borrar esta respuesta.";
            exit;
        }
        // Omitimos esta línea para borrarla
        continue;
    }

    $nuevasLineas[] = $linea;
}

file_put_contents($rutaRespuestas, implode(PHP_EOL, $nuevasLineas));

header("Location: ver.php?archivo=" . urlencode($archivo));
exit;
?>