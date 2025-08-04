<?php
// Ruta del archivo donde se guarda la URL
$archivo_imagen = 'imagen_foro.txt';

// Si se envió el formulario, actualiza el archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_url = trim($_POST['nueva_url']);

    // Validación básica de URL
    if (filter_var($nueva_url, FILTER_VALIDATE_URL)) {
        file_put_contents($archivo_imagen, $nueva_url);
        $mensaje = "Imagen actualizada correctamente.";
    } else {
        $mensaje = "URL inválida. Intenta con una URL válida.";
    }
}

// Leer la URL actual (por si ya existe)
$imagen_actual = file_exists($archivo_imagen) ? file_get_contents($archivo_imagen) : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Imagen del Foro</title>
</head>
<body style="background:#111; color:white; font-family:sans-serif; padding:20px;">

    <h2 style="text-align:center;">Editar Imagen del Foro</h2>

    <?php if (!empty($mensaje)): ?>
        <p style="background:#333; padding:10px; border-radius:6px; color:white;"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form method="POST" style="max-width:600px; margin:auto;">
        <input 
            type="text" 
            name="nueva_url" 
            value="<?php echo htmlspecialchars($imagen_actual); ?>" 
            placeholder="Pega la URL de la nueva imagen"
            style="width:100%; padding:10px; margin-bottom:10px; border-radius:8px; border:none; font-size:16px;"
            required
        >

        <button type="submit"
            style="background:#222; color:white; padding:12px 20px; border:none; border-radius:10px; font-weight:bold; cursor:pointer; box-shadow:0 0 15px #fff;">
            Guardar
        </button>

        <button 
            type="button" 
            onclick="window.location.href='panel_admin.php'" 
            style="background:#222; color:white; padding:12px 20px; border:none; border-radius:10px; font-weight:bold; cursor:pointer; box-shadow:0 0 15px #fff; margin-left:10px;">
            Cancelar
        </button>
    </form>

    <?php if (!empty($imagen_actual)): ?>
        <div style="text-align:center; margin-top:30px;">
            <p>Vista previa de la imagen actual:</p>
            <img src="<?php echo htmlspecialchars($imagen_actual); ?>" alt="Imagen actual" style="max-width:300px; border-radius:10px; box-shadow:0 0 10px #fff;">
        </div>
    <?php endif; ?>

</body>
</html>