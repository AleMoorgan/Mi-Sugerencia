<?php
include 'db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM libros WHERE id = $id";
$result = $conexion->query($sql);
if ($result && $result->num_rows > 0) {
    $libro = $result->fetch_assoc();
} else {
    die("Libro no encontrado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($libro['titulo']); ?></title>
  <link rel="stylesheet" href="css/estilos.css">
  <style>
    body {
      margin-left: 40px;
      font-family: sans-serif;
      background-image: url('https://i.pinimg.com/736x/16/7c/7a/167c7ad808894a40a2415fada32fd987.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: repeat;
      height: 100vh;
      color: #000;
    }
    h1 {
      font-style: italic;
      font-family: sans-serif;
      margin-bottom: 20px;
    }
    .contenedor-libro {
      display: flex;
      align-items: flex-start;
      gap: 30px;
      max-width: 1100px;
      margin: 0 auto;
      font-size: 18px;
      flex-wrap: wrap;
    }
    .datos-libro {
      max-width: 300px;
    }
    .imagen-libro img {
      max-width: 250px;
      height: auto;
    }
    form {
      background-color: rgba(255, 255, 255, 0.5);
      padding: 20px;
      border-radius: 8px;
      width: 230px;
      box-sizing: border-box;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    .resultados {
      margin-top: 15px;
      font-size: 16px;
    }
    textarea {
      width: 100%;
      max-width: 700px;
    }
  </style>
</head>
<body>
  <h1><?php echo htmlspecialchars($libro['titulo']); ?></h1>

  <div class="contenedor-libro">
    <!-- Datos del libro -->
    <div class="datos-libro">
      <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
      <p><strong>Año:</strong> <?php echo htmlspecialchars($libro['year']); ?></p>
      <p><strong>Calificación:</strong> <?php echo htmlspecialchars($libro['calif']); ?></p>
      <p><strong>Reseña:</strong> <?php echo htmlspecialchars($libro['resena']); ?></p>
    </div>

    <!-- Imagen del libro (al centro) -->
    <div class="imagen-libro">
      <img src="img/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="Portada del libro">
    </div>

    <!-- Formulario de votación (a la derecha) -->
    <form id="formulario">
      <p>¿Ya leíste este libro?<br>¿Te gustó?</p>

      <label>
        <input type="radio" name="opcion" value="1" checked> Sí, me encantó.
      </label><br>

      <label>
        <input type="radio" name="opcion" value="2"> Mmm no.
      </label><br><br>

      <button type="submit">Enviar</button>

      <div class="resultados">
        <p>❤️‍🔥 Me encantó: <span id="contadorSi">0</span></p>
        <p>💔 No me gustó: <span id="contadorNo">0</span></p>
      </div>
    </form>
  </div>

<script>
const libroId = <?php echo $id; ?>;

function actualizarVotos() {
  fetch(`votos/votos_${libroId}.txt`)
    .then(res => res.text())
    .then(data => {
      const [si, no] = data.split('|');
      document.getElementById('contadorSi').textContent = si;
      document.getElementById('contadorNo').textContent = no;
    });
}

document.getElementById('formulario').addEventListener('submit', function(e) {
  e.preventDefault();
  const opcion = document.querySelector('input[name="opcion"]:checked').value;

  fetch('votar.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `id=${libroId}&opcion=${opcion}`
  })
  .then(res => res.json())
  .then(data => {
    document.getElementById('contadorSi').textContent = data.si;
    document.getElementById('contadorNo').textContent = data.no;
    alert('¡Gracias por tu opinión!');
  });
});

// Actualizar votos cada 3 segundos
actualizarVotos();
setInterval(actualizarVotos, 3000);
</script>

  <hr style="border: none; height: 5px; background-color: hotpink; margin-top: 40px;">

  <!-- Opiniones de usuarios -->
  <h2>Opiniones</h2>
  <?php
    $opinionesArchivo = "opiniones/opiniones_" . $id . ".txt";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['opinion'])) {
        $op = strip_tags($_POST['opinion']);
        file_put_contents($opinionesArchivo, $op . "\n", FILE_APPEND);
    }

    if (file_exists($opinionesArchivo)) {
        echo "<ul>";
        $opiniones = file($opinionesArchivo, FILE_IGNORE_NEW_LINES);
        foreach ($opiniones as $op) {
            echo "<li>" . htmlspecialchars($op) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No hay opiniones aún.</p>";
    }
  ?>

  <h3 style="font-size:18px">¡Deja tu opinión!</h3>
  <form method="post">
    <textarea name="opinion" rows="4" required></textarea><br>
    <button type="submit" style="background-color: hotpink; color: white; padding: 10px 20px; border: none; border-radius: 6px; font-size: 18px;">Enviar</button>
  </form>
</body>
</html>