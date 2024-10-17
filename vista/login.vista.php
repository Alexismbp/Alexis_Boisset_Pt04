<!-- Alexis Boisset -->
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logar-se</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <h1>Logar-se</h1>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="../controlador/login.controller.php" method="POST">
        <label for="username">Nom d'usuari:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Contrasenya:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Logar-se">
    </form>

    <a href="../index.php">Tornar a la pàgina principal</a>
</body>

</html>