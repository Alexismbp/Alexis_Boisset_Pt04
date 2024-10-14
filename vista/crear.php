<?php
// Alexis Boisset

// Inicia la sessió
session_start();
// Comprova si s'està editant i estableix l'atribut readonly
$edit = ($_GET["editant"]) ? "readonly" : "";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Elemento</title>
    <link rel="stylesheet" href="../styles/styles_crear.css">
</head>

<body>
    <h1>Crear nou element</h1>
    <form action="../controlador/save.php" method="POST">
        <!-- Missatges d'èxit o error -->
        <?php if (isset($_GET["success"])) { ?>
            <span class="ole">¡Article guardat correctament!</span>
            <?php session_destroy() // Elimina les variables de sessió 
            ?>
        <?php } elseif (isset($_GET["failure"])) { ?>
            <span class="noole">Alguna cosa no ha funcionat com hauria.</span>
        <?php } ?>

        <!-- Mostrar errors si existeixen -->
        <?php if ($_GET['errors'] == 1) { ?>
            <span class="noole">Error: És obligatori un títol.</span>
        <?php } elseif ($_GET['errors'] == 3) { ?>
            <span class="noole">Error: És obligatori una descripció.</span>
        <?php } elseif ($_GET['errors'] == 4) { ?>
            <span class="noole">Error: És obligatori un títol. <br>
                Error: És obligatori una descripció.</span>
        <?php } elseif ($_GET['errors'] == 5) { ?>
            <span class="noole">Error: La ID ha de ser numèrica. </span>
        <?php } elseif ($_GET['errors'] == 6) { ?>
            <span class="noole">Error: La ID ha de ser numèrica. <br>
                Error: És obligatori un títol. </span>
        <?php } elseif ($_GET['errors'] == 8) { ?>
            <span class="noole">Error: La ID ha de ser numèrica.<br>
                Error: És obligatori una descripció. </span>
        <?php } elseif ($_GET['errors'] == 9) { ?>
            <span class="noole">Error: La ID ha de ser numèrica <br>
                Error: És obligatori un títol. <br>
                Error: És obligatori una descripció. </span>
        <?php } ?>


        <!-- Formulari -->
        <label for="id">ID de l'Article (només per editar):</label>
        <input type="text" id="id" name="id" placeholder="<?php echo isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'] ?? ''; ?>" <?php echo $edit ?>>

        <label for="nombre">Nom de l'Article:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $_SESSION['nombre'] ?? ''; ?>" placeholder="Escriu el nom de l'article">

        <label for="descripcion">Descripció de l'Article:</label>
        <textarea id="descripcion" name="descripcion" rows="4" placeholder="Escriu la descripció de l'article"><?php echo $_SESSION['descripcion'] ?? ''; ?></textarea>

        <input type="submit" value="Enviar">
    </form>

    <!-- Botó per tornar a Index.php sense sessió per no emportar-se dades entre formularis-->
    <br>
    <a href="../controlador/logout.php">Tornar</a>
</body>

</html>