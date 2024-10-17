<!-- Alexis Boisset -->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrar-se</title>
    <link rel="stylesheet" href="styles/styles_register.css">
</head>

<body>
    <div class="container">
        <h1>Enregistrar-se</h1>

        <form action="../controlador/register.controller.php" method="POST">
            <!-- FEEDBACK -->
            <?php
            // Success o Failure
            if (isset($_SESSION['success'])) {
                echo '<div class="message success">' . $_SESSION['success'] . '</div>'; // Missatge d'èxit.
                unset($_SESSION['success']); // Neteja el missatge de la sessió.
            } elseif (isset($_SESSION['failure'])) {
                echo '<div class="message error">' . $_SESSION['failure'] . '</div>'; // Missatge d'error.
                unset($_SESSION['failure']); // Neteja el missatge de la sessió.
            }
            // Mostra errors si existeixen.
            if (isset($_SESSION['errors'])) {
                foreach ($_SESSION['errors'] as $error) {
                    echo '<div class="message error">' . $error . '</div>'; // Mostra cada error.
                }
                unset($_SESSION['errors']); // Neteja els errors de la sessió.
            }
            ?>

            <label for="username">Nom d'usuari:</label>
            <input type="text" id="username" name="username" class="input-field" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" class="input-field" required>

            <label for="equip">Equip favorit:</label>
            <select id="equip" name="equip" class="input-field" required>
                <option value="">-- Selecciona el teu equip favorit --</option>
                <option value="FC Barcelona">FC Barcelona</option>
                <option value="Real Madrid">Real Madrid</option>
                <option value="Atlético de Madrid">Atlético de Madrid</option>
                <option value="Sevilla FC">Sevilla FC</option>
                <option value="Valencia CF">Valencia CF</option>
                <option value="Villarreal CF">Villarreal CF</option>
                <option value="Athletic Club">Athletic Club</option>
                <option value="Real Sociedad">Real Sociedad</option>
                <option value="Real Betis">Real Betis</option>
                <option value="Rayo Vallecano">Rayo Vallecano</option>
                <option value="Celta de Vigo">Celta de Vigo</option>
                <option value="CA Osasuna">CA Osasuna</option>
                <option value="RCD Mallorca">RCD Mallorca</option>
                <option value="Girona FC">Girona FC</option>
                <option value="UD Almería">UD Almería</option>
                <option value="Getafe CF">Getafe CF</option>
                <option value="UD Las Palmas">UD Las Palmas</option>
                <option value="Deportivo Alavés">Deportivo Alavés</option>
                <option value="Granada CF">Granada CF</option>
            </select>

            <label for="password">Contrasenya:</label>
            <input type="password" id="password" name="password" class="input-field" required>

            <label for="password_confirm">Torna a introduir la contrasenya:</label>
            <input type="password" id="password_confirm" name="password_confirm" class="input-field" required>

            <input type="submit" class="btn-submit" value="Enregistrar-se">
        </form>

        <a href="../index.php" class="btn-back">Tornar a la pàgina principal</a>
    </div>
</body>

</html>
