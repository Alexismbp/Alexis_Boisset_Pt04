<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrar-se</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <h1>Enregistrar-se</h1>

    <form action="register.php" method="POST">
        <label for="username">Nom d'usuari:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Contrasenya:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Enregistrar-se">
    </form>

    <a href="index.php">Tornar a la pàgina principal</a>
</body>
</html>