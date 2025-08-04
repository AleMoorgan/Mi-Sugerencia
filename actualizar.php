<?php
include 'db.php';

$id     = intval($_POST['id']);
$titulo = $_POST['titulo'];
$autor  = $_POST['autor'];
$year   = intval($_POST['year']);
$calif  = floatval($_POST['calif']);
$resena = $_POST['resena'];

// Obtener imagen actual
$sql_img = "SELECT imagen FROM libros WHERE id = ?";
$stmt_img = $conexion->prepare($sql_img);
$stmt_img->bind_param("i", $id);
$stmt_img->execute();
$result = $stmt_img->get_result();
$libro = $result->fetch_assoc();
$imagenActual = $libro['imagen'];
$stmt_img->close();

$nuevaImagen = $imagenActual;

// Si se subió una nueva imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $nombreImagen = basename($_FILES['imagen']['name']);
    $rutaDestino = "img/" . $nombreImagen;

    // Mover la imagen
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        $nuevaImagen = $nombreImagen;
    } else {
        echo "Error al subir la nueva imagen. Código: " . $_FILES['imagen']['error'];
        exit;
    }
}

// Actualizar libro
$sql = "UPDATE libros SET titulo = ?, autor = ?, year = ?, calif = ?, resena = ?, imagen = ? WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssidssi", $titulo, $autor, $year, $calif, $resena, $nuevaImagen, $id);

if ($stmt->execute()) {
    echo "Libro actualizado correctamente. <a href='gest_libros.php'>Volver</a>";
} else {
    echo "Error al actualizar: " . $stmt->error;
}

$stmt->close();
?>