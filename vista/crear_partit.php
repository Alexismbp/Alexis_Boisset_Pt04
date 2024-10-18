<?php
// Alexis Boisset

session_start(); // Inicia la sessió per a gestionar l'estat de l'usuari i les dades del formulari.
require "../controlador/config.php"; // Detecció de temps d'inactivitat

// Si s'ha fet click al boto "Netejar"
if (isset($_GET['netejar'])) {
    $_SESSION = array();  // Neteja totes les variables de la sessió.
}

// Comprova si s'està editant i estableix l'atribut $edit
$edit = (isset($_SESSION['editant'])) ? "readonly" : ""; // Si l'usuari està editant, estableix l'atribut $edit per evitar canvis.
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear o Editar Partit</title>
    <link rel="stylesheet" href="styles/styles_crear.css"> <!-- Enllaç al fitxer de CSS per estilitzar la pàgina. -->
</head>

<body>
    <div class="container">
        <h1>Crear o Editar Partit</h1> <!-- Títol de la pàgina. -->
        <form action="../controlador/save_partit.php" method="POST"> <!-- Formulari per crear o editar un partit. -->
            <!-- Missatges d'èxit o error -->
            <?php
            // Mostra missatges d'èxit o error si existeixen.
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

            <!-- Formulari -->
            <label for="id">ID del Partit (només per editar):</label>
            <input type="text" id="id" name="id" class="input-field" placeholder="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>" <?php echo $edit ?>> <!-- Input per l'ID del partit, només editable si no s'està editant. -->

            <?php if ($_SESSION['editant']) { ?>
                <label for="equip_local">Equip Local:</label>
                <input type="text" id="equip_local" name="equip_local" class="input-field" value="<?php echo $_SESSION['equip_local']; ?>" placeholder="Escriu el nom de l'equip local" <?php echo $edit ?>> <!-- Input per l'equip local, només lectura. -->

                <label for="equip_visitant">Equip Visitant:</label>
                <input type="text" id="equip_visitant" name="equip_visitant" class="input-field" value="<?php echo $_SESSION['equip_visitant']; ?>" placeholder="Escriu el nom de l'equip visitant" <?php echo $edit ?>> <!-- Input per l'equip visitant, només lectura. -->
            <?php } else { ?>
                <label for="equip_local">Equip Local:</label>
                <select id="equip_local" name="equip_local" class="input-field">
                    <option value="">-- Selecciona un equip --</option>
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

                <label for="equip_visitant">Equip Visitant:</label>
                <select id="equip_visitant" name="equip_visitant" class="input-field">
                    <option value="">-- Selecciona un equip --</option>
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

            <?php } ?>

            <label for="data">Data del Partit:</label>
            <input type="date" id="data" name="data" class="input-field" value="<?php echo isset($_SESSION['data']) ? $_SESSION['data'] : ''; ?>"> <!-- Input per la data del partit. -->

            <label for="gols_local">Gols Local (Opcional):</label>
            <input type="number" id="gols_local" name="gols_local" class="input-field" value="<?php echo isset($_SESSION['gols_local']) ? $_SESSION['gols_local'] : ''; ?>"> <!-- Input per gols locals, opcional. -->

            <label for="gols_visitant">Gols Visitant (Opcional):</label>
            <input type="number" id="gols_visitant" name="gols_visitant" class="input-field" value="<?php echo isset($_SESSION['gols_visitant']) ? $_SESSION['gols_visitant'] : ''; ?>"> <!-- Input per gols visitants, opcional. -->

            <button type="submit" class="btn-submit">Guardar</button> <!-- Botó per guardar els canvis. -->
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?netejar=true" class="btn-back">Netejar</a> <!-- Botó per netejar els camps del formulari. -->
            <a href="../index.php" class="btn-back">Tornar enrere</a> <!-- Botó per tornar a index.php -->
        </form>
    </div>
</body>

</html>