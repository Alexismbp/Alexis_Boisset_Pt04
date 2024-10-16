<?php
// Alexis Boisset

session_start(); // Inicia la sessió per a gestionar l'estat de l'usuari i les dades del formulari.

// Si s'ha fet click al boto "Netejar"
if (isset($_GET['netejar'])) {
    $_SESSION = array();  // Neteja totes les variables de la sessió.
}

// Comprova si s'està editant i estableix l'atribut readonly
$edit = (isset($_SESSION['editant'])) ? "readonly" : ""; // Si l'usuari està editant, estableix l'atribut readonly per evitar canvis.
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
        <form action="../controlador/save_partido.php" method="POST"> <!-- Formulari per crear o editar un partit. -->
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

            <label for="equipo_local">Equip Local:</label>
            <input type="text" id="equipo_local" name="equipo_local" class="input-field" value="<?php echo isset($_SESSION['equipo_local']) ? $_SESSION['equipo_local'] : ''; ?>" placeholder="Escriu el nom de l'equip local"> <!-- Input per l'equip local. -->

            <label for="equipo_visitante">Equip Visitant:</label>
            <input type="text" id="equipo_visitante" name="equipo_visitante" class="input-field" value="<?php echo isset($_SESSION['equipo_visitante']) ? $_SESSION['equipo_visitante'] : ''; ?>" placeholder="Escriu el nom de l'equip visitant"> <!-- Input per l'equip visitant. -->

            <label for="fecha">Data del Partit:</label>
            <input type="date" id="fecha" name="fecha" class="input-field" value="<?php echo isset($_SESSION['fecha']) ? $_SESSION['fecha'] : ''; ?>"> <!-- Input per la data del partit. -->

            <label for="goles_local">Gols Local (Opcional):</label>
            <input type="number" id="goles_local" name="goles_local" class="input-field" value="<?php echo isset($_SESSION['goles_local']) ? $_SESSION['goles_local'] : ''; ?>"> <!-- Input per gols locals, opcional. -->

            <label for="goles_visitante">Gols Visitant (Opcional):</label>
            <input type="number" id="goles_visitante" name="goles_visitante" class="input-field" value="<?php echo isset($_SESSION['goles_visitante']) ? $_SESSION['goles_visitante'] : ''; ?>"> <!-- Input per gols visitants, opcional. -->

            <input type="submit" value="Enviar" class="btn-submit"> <!-- Botó per enviar el formulari. -->
        </form>

        <a href="crear_partido.php?netejar=true" class="btn-back">Netejar</a> <!-- Enllaç per netejar el formulari. -->
        <br>
        <a href="../index.php" class="btn-back">Tornar</a> <!-- Enllaç per tornar a la pàgina principal. -->
    </div>
</body>

</html>
