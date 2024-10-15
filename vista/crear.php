<?php
// Alexis Boisset

// Inicia la sessió
session_start();

// Si s'ha fet click al boto "Netejar"
if (isset($_GET['netejar'])) {
    $_SESSION = array();  // Limpiar todas las variables de la sesión
}

// Comprova si s'està editant i estableix l'atribut readonly
$edit = (isset($_SESSION['editant'])) ? "readonly" : "";

?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Elemento</title>
    <link rel="stylesheet" href="styles/styles_crear.css">
</head>

<body>
    <div class="container">
        <h1>Crear nou element</h1>
        <form action="../controlador/save_edit.php" method="POST">
            <!-- Missatges d'èxit o error -->
            <?php
            if (isset($_SESSION['success'])) {
                echo '<div class="message success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']); // Limpiamos el mensaje después de mostrarlo
            } elseif (isset($_SESSION['failure'])) {
                echo '<div class="message error">' . $_SESSION['failure'] . '</div>';
                unset($_SESSION['failure']); // Limpiamos el mensaje después de mostrarlo
            }

            if (isset($_SESSION['errors'])) {
                foreach ($_SESSION['errors'] as $error) {
                    echo '<div class="message error">' . $error . '</div>';
                }
                unset($_SESSION['errors']); // Limpiamos los errores después de mostrarlos
            }
            ?>

            <!-- Formulari -->
            <label for="id">ID de l'Article (només per editar):</label>
            <input type="text" id="id" name="id" class="input-field" placeholder="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>" <?php echo $edit ?>>

            <label for="nombre">Nom de l'Article:</label>
            <input type="text" id="nombre" name="nombre" class="input-field" value="<?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : ''; ?>" placeholder="Escriu el nom de l'article">

            <label for="descripcion">Descripció de l'Article:</label>
            <textarea id="descripcion" name="descripcion" class="input-field" rows="4" placeholder="Escriu la descripció de l'article"><?php echo $_SESSION['descripcion'] ?? ''; ?></textarea>

            <input type="submit" value="Enviar" class="btn-submit">
        </form>

        <a href="crear.php?netejar=true" class="btn-back">Netejar</a>
        <br>
        <a href="../index.php" class="btn-back">Tornar</a>
    </div>
</body>

</html>