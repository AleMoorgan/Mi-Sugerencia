<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['admin_pass'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Hello Math Books</title>

<style>
    body {
        background-image: url('https://i.pinimg.com/736x/ab/89/34/ab893427c3487dff27e1937f107231b2.jpg'); /* Imagen */
        background-size: cover;             /* Para que cubra toda la pantalla */
        background-repeat: no-repeat;
        font-family: sans-serif;
    }

    h2 {
    text-align: center;
    font-size: 2.5em;
    margin-top: 80px;
    color: #fff;  
    text-shadow:
        0 0 5px #fff,
        0 0 10px #fff,
        0 0 20px #fff,
        0 0 40px #fff,
        0 0 80px #fff;
    }

    form {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 15px;
        width: 300px;
        margin: 100px auto;
        box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }
</style>

</head>
<body>
    <h2 style="text-align:center; color:white; font-size: 40px">Modo Administrador</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red; text-align:center;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" style="text-align:center;">
        <input type="password" name="admin_pass" placeholder="Contraseña admin" required
               style="padding: 10px; width: 250px;"><br><br>
        <button type="submit"
                style="background-color: black; color: white; padding: 10px 20px; border: none; border-radius: 8px;">
            Entrar
        </button>
    </form>
</body>
</html>