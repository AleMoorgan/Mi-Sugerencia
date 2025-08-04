<?php
include 'db.php';

// Obtener el ID desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM libros WHERE id = $id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows === 0) {
    die("Libro no encontrado.");
}

$libro = $resultado->fetch_assoc();
?>

<style>
  body {
    background-image: url('https://i.pinimg.com/736x/a9/3b/04/a93b0415c782a957930362f4e3b5d0c6.jpg'); /* Cambia esta ruta */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 40px 0;
  }

  form {
    background: black; /* Fondo negro semi-transparente */
    max-width: 600px;
    margin: auto;
    padding: 20px 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px #fff;
  }

  input[type="text"],
  input[type="number"],
  textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
  }

  input[type="file"] {
    margin-bottom: 15px;
  }

  button {
    background: #222;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 0 8px #fff;
    transition: background 0.3s;
  }

  button:hover {
    background: #444;
  }

  p {
    color: white;
  }

  img {
    max-width: 150px;
    border-radius: 8px;
    box-shadow: 0 0 8px #fff;
    margin-bottom: 15px;
  }
</style>

<h2 style="color:white; text-align:center;">Editar Libro</h2>

<form action="actualizar.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">

    <input type="text" name="titulo" value="<?php echo htmlspecialchars($libro['titulo']); ?>" placeholder="Título" required>

    <input type="text" name="autor" value="<?php echo htmlspecialchars($libro['autor']); ?>" placeholder="Autor" required>

    <input type="number" name="year" value="<?php echo $libro['year']; ?>" min="0" max="2100" placeholder="Año" required>

    <input type="number" name="calif" value="<?php echo $libro['calif']; ?>" min="0" max="10" step="0.1" placeholder="Calificación" required>

    <textarea name="resena" rows="4" placeholder="Reseña" required><?php echo htmlspecialchars($libro['resena']); ?></textarea>

    <p>Imagen actual: <strong><?php echo htmlspecialchars($libro['imagen']); ?></strong></p>
    <img src="img/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="Portada"><br>

    <label>Subir nueva imagen (opcional):</label><br>
    <input type="file" name="imagen">

    <button type="submit">Actualizar</button>
<button 
  type="button" 
  onclick="window.location.href='gest_libros.php'" 
  style="
    background: #222;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 0 15px #fff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin-left: 10px;
    transition: background 0.3s;
  "
  onmouseover="this.style.background='#444'"
  onmouseout="this.style.background='#222'"
>
  Cancelar
</button>
</button>
</form>