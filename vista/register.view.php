<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrar-se</title>
    <link rel="stylesheet" href="styles/styles_register.css">
    <!-- Enlace al archivo JavaScript externo -->
    <script src="../scripts/lligaequip.js" defer></script>
</head>

<body>
    <div class="container">
        <h1>Enregistrar-se</h1>

        <form action="../controlador/register.controller.php" method="POST">
            <!-- FEEDBACK -->
            <?php
            if (isset($_SESSION['success'])) {
                echo '<div class="message success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            } elseif (isset($_SESSION['failure'])) {
                echo '<div class="message error">' . $_SESSION['failure'] . '</div>';
                unset($_SESSION['failure']);
            }
            if (isset($_SESSION['errors'])) {
                foreach ($_SESSION['errors'] as $error) {
                    echo '<div class="message error">' . $error . '</div>';
                }
                unset($_SESSION['errors']);
            }
            ?>

            <label for="username">Nom d'usuari:</label>
            <input type="text" id="username" name="username" class="input-field" value="<?php echo $_SESSION['username'] ?>" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" class="input-field" value="<?php echo $_SESSION['email'] ?>" required>

            <!-- Select per la Lliga -->
            <label for="lliga">Lliga:</label>
            <select id="lliga" name="lliga" class="input-field" onchange="actualitzarEquips()" required>
                <option value="">-- Selecciona la teva lliga --</option>
                <option value="LaLiga">LaLiga</option>
                <option value="Premier League">Premier League</option>
                <option value="Ligue 1">Ligue 1</option>
            </select>

            <!-- Select per l'Equip favorit -->
            <label for="equip_favorit">Equip favorit:</label>
            <select id="equip_favorit" name="equip_favorit" class="input-field" required>
                <option value="">-- Selecciona el teu equip favorit --</option>
                <!-- Opcions d'equips seran afegides dinàmicament amb JavaScript -->
            </select>

            <label for="password">Contrasenya:</label>
            <input type="password" id="password" name="password" class="input-field" required>

            <label for="password_confirm">Torna a introduir la contrasenya:</label>
            <input type="password" id="password_confirm" name="password_confirm" class="input-field" required>

            <input type="submit" class="btn-submit" value="Enregistrar-se">
        </form>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?netejar=true" class="btn-back">Netejar</a>
        <br>
        <a href="../index.php" class="btn-back">Tornar a la pàgina principal</a>
    </div>
</body>

</html>
