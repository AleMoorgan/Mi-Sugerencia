<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Mi Panel</title>
</head>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background-image: url('https://i.pinimg.com/736x/16/7c/7a/167c7ad808894a40a2415fada32fd987.jpg'); /* Fondo de Hello Kitty */
            background-size: cover;
            background-position: center;
            background-repeat:repeat;
            height: 100vh;
            color: #000;
        }

        .container {
            position: relative;
            z-index: 1;
            text-align: center;
            padding-top: 60px;
        }

        h1 {
            font-size: 50px;
            color: black;
            margin-bottom: 20px;
        }

        .subtitulo {
            font-family: sans serif;
            font-size: 24px;
            font-style: italic;
            color: black;
            margin-top: -10px;
            margin-bottom: 30px;
        }

        .nav {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin: 30px 0;
        }

        .nav a {
            text-decoration: none;
            color: hotpink;
            font-weight: bold;
            font-size: 20px;
            font-style: italic;
            transition: color 0.3s ease;
        }

        .nav a:hover {
            color: #e91e63;
        }

        .noticias {
            background-color: rgba(255, 255, 255, 0.8);
            margin: 40px auto;
            padding: 20px;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .noticias h2 {
            font-size: 30px;
            color: #e91e63;
            font-style: italic;
            margin-bottom: 20px;
        }

        .img-noticia {
  width: 450px;   /* o el tamaño que quieras */
  height: auto;   /* para mantener proporción */
  border-radius: 8px;  /* opcional, para bordes redondeados */
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);  /* opcional, sombra */
}

        .leer-mas {
    display: inline-block;
    margin-top: 10px;
    text-decoration: none;
    color: #e91e63;
    font-weight: bold;
    transition: color 0.3s ease;
}

.leer-mas:hover {
    color: hotpink;
    text-decoration: underline;
}

        .logout {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #e91e63;
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 20px;
            cursor: pointer;
        }

        .logout:hover {
            background-color: #d81b60;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="container">
        <h1>HELLO MATH BOOKS</h1>
        <p class="subtitulo">"Descubre al matemático que llevas dentro"</p>

        <div class="nav">
            <a href="biblio.php">Biblioteca</a>
            <a href="foro.php">Foro</a>
        </div>

<?php
$noticia = json_decode(file_get_contents('noticia.json'), true);
?>

<div class="noticias">
    <h2>⋆｡‧˚ HM NEWS ˚‧｡⋆</h2>
    <div class="noticia">
        <img class="img-noticia" src="<?= htmlspecialchars($noticia['imagen']) ?>" alt="Imagen noticia 1">
        <div>
            <h3><?= htmlspecialchars($noticia['titulo']) ?></h3>
            <p>Accede al siguiente link para conocer más:</p>
            <a href="<?= htmlspecialchars($noticia['link']) ?>" target="_blank" class="leer-mas">NOTICIA</a>
        </div>
    </div>
</div>
<div style="text-align: center; margin-top: 20px;">
    <!-- Nuevo botón a la izquierda -->
    <a href="admin.php" 
       style="background-color: #e91e63; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-size: 20px; text-decoration: none; margin-right: 10px;">
        Panel Admin
    </a>

    <!-- Botón de cerrar sesión -->
    <a href="logout.php" 
       style="background-color: hotpink; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-size: 20px; text-decoration: none;">
        Cerrar sesión
    </a>
</div>

</body>
</html>