<?php
// Alexis Boisset

session_start(); // Inicia la sessió per a gestionar l'estat de l'usuari i les dades del formulari.

// Si s'ha fet click al boto "Netejar"
if (isset($_GET['netejar'])) {
    $_SESSION = array();  // Neteja totes les variables de la sessió.
}

// Comprova si s'està editant i estableix l'atribut readonly
$edit = (isset($_SESSION['editant'])) ? "readonly" : ""; // Si l'usuari està editant, estableix l'atribut readonly per evitar canvis.

// Funció per obtenir el nom de l'equip a partir de la seva ID
function getTeamName($conn, $id) {
    $stmt = $conn->prepare("SELECT nom FROM equips WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Obtenim els noms dels equips per a mostrar-los
$equip_local_name = isset($_SESSION['equip_local']) ? getTeamName($conn, $_SESSION['equip_local']) : '';
$equip_visitant_name = isset($_SESSION['equip_visitant']) ? getTeamName($conn, $_SESSION['equip_visitant']) : '';
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

            <label for="equip_local">Equip Local:</label>
            <input type="text" id="equip_local" name="equip_local" class="input-field" value="<?php echo $equip_local_name; ?>" placeholder="Escriu el nom de l'equip local" readonly> <!-- Input per l'equip local, només lectura. -->

            <label for="equip_visitant">Equip Visitant:</label>
            <input type="text" id="equip_visitant" name="equip_visitant" class="input-field" value="<?php echo $equip_visitant_name; ?>" placeholder="Escriu el nom de l'equip visitant" readonly> <!-- Input per l'equip visitant, només lectura. -->

            <label for="data">Data del Partit:</label>
            <input type="date" id="data" name="data" class="input-field" value="<?php echo isset($_SESSION['data']) ? $_SESSION['data'] : ''; ?>"> <!-- Input per la data del partit. -->

            <label for="gols_local">Gols Local (Opcional):</label>
            <input type="number" id="gols_local" name="gols_local" class="input-field" value="<?php echo isset($_SESSION['gols_local']) ? $_SESSION['gols_local'] : ''; ?>"> <!-- Input per gols locals, opcional. -->

            <label for="gols_visitant">Gols Visitant (Opcional):</label>
            <input type="number" id="gols_visitant" name="gols_visitant" class="input-field" value="<?php echo isset($_SESSION['gols_visitant']) ? $_SESSION['gols_visitant'] : ''; ?>"> <!-- Input per gols visitants, opcional. -->

            <button type="submit" class="button">Guardar</button> <!-- Botó per guardar els canvis. -->
            <button type="submit" name="netejar" class="button">Netejar</button> <!-- Botó per netejar els camps del formulari. -->
        </form>
    </div>
</body>

</html>
