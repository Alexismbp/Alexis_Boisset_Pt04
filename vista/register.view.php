<!-- Alexis Boisset -->
<?php
session_start();
require "../controlador/config.php"; // Detecció de temps d'inactivitat

if (isset($_GET['netejar'])) {
    $_SESSION = array();  // Neteja totes les variables de la sessió.
}

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
            <input type="text" id="username" name="username" class="input-field" value="<?php echo $_SESSION['username'] ?>" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" class="input-field" value="<?php echo $_SESSION['email'] ?>" required>

            <label for="equip">Equip favorit:</label>

            <select id="equip" name="equip" class="input-field" required>
                <option value="">-- Selecciona el teu equip favorit --</option>
                <option value="FC Barcelona" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'FC Barcelona') ? 'selected' : ''; ?>>FC Barcelona</option>
                <option value="Real Madrid" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Real Madrid') ? 'selected' : ''; ?>>Real Madrid</option>
                <option value="Atlético de Madrid" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Atlético de Madrid') ? 'selected' : ''; ?>>Atlético de Madrid</option>
                <option value="Sevilla FC" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Sevilla FC') ? 'selected' : ''; ?>>Sevilla FC</option>
                <option value="Valencia CF" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Valencia CF') ? 'selected' : ''; ?>>Valencia CF</option>
                <option value="Villarreal CF" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Villarreal CF') ? 'selected' : ''; ?>>Villarreal CF</option>
                <option value="Athletic Club" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Athletic Club') ? 'selected' : ''; ?>>Athletic Club</option>
                <option value="Real Sociedad" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Real Sociedad') ? 'selected' : ''; ?>>Real Sociedad</option>
                <option value="Real Betis" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Real Betis') ? 'selected' : ''; ?>>Real Betis</option>
                <option value="Rayo Vallecano" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Rayo Vallecano') ? 'selected' : ''; ?>>Rayo Vallecano</option>
                <option value="Celta de Vigo" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Celta de Vigo') ? 'selected' : ''; ?>>Celta de Vigo</option>
                <option value="CA Osasuna" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'CA Osasuna') ? 'selected' : ''; ?>>CA Osasuna</option>
                <option value="RCD Mallorca" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'RCD Mallorca') ? 'selected' : ''; ?>>RCD Mallorca</option>
                <option value="Girona FC" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Girona FC') ? 'selected' : ''; ?>>Girona FC</option>
                <option value="UD Almería" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'UD Almería') ? 'selected' : ''; ?>>UD Almería</option>
                <option value="Getafe CF" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Getafe CF') ? 'selected' : ''; ?>>Getafe CF</option>
                <option value="UD Las Palmas" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'UD Las Palmas') ? 'selected' : ''; ?>>UD Las Palmas</option>
                <option value="Deportivo Alavés" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Deportivo Alavés') ? 'selected' : ''; ?>>Deportivo Alavés</option>
                <option value="Granada CF" <?php echo (isset($_SESSION['equip']) && $_SESSION['equip'] == 'Granada CF') ? 'selected' : ''; ?>>Granada CF</option>
            </select>


            <label for="password">Contrasenya:</label>
            <input type="password" id="password" name="password" class="input-field" required>

            <label for="password_confirm">Torna a introduir la contrasenya:</label>
            <input type="password" id="password_confirm" name="password_confirm" class="input-field" required>

            <input type="submit" class="btn-submit" value="Enregistrar-se">
        </form>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?netejar=true" class="btn-back">Netejar</a> <!-- Botó per netejar els camps del formulari. -->
        <br>
        <a href="../index.php" class="btn-back">Tornar a la pàgina principal</a>
    </div>
</body>

</html>