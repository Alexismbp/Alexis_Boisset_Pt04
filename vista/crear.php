<?php
// Alexis Boisset

// Inicia la sessió
session_start();
// Comprova si s'està editant i estableix l'atribut readonly
$edit = ($_GET["editant"]) ? "readonly" : "";

$errorMessages = [
    1 => 'Error: És obligatori un títol.',
    3 => 'Error: És obligatori una descripció.',
    4 => 'Error: És obligatori un títol. <br> Error: És obligatori una descripció.',
    5 => 'Error: La ID ha de ser numèrica.',
    6 => 'Error: La ID ha de ser numèrica. <br> Error: És obligatori un títol.',
    8 => 'Error: La ID ha de ser numèrica. <br> Error: És obligatori una descripció.',
    9 => 'Error: La ID ha de ser numèrica. <br> Error: És obligatori un títol. <br> Error: És obligatori una descripció.'
];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Elemento</title>
    <link rel="stylesheet" href="./styles/styles_crear.css">
</head>

<body>
    <h1>Crear nou element</h1>
    <form action="../controlador/save_edit.php" method="POST">
        <!-- Missatges d'èxit o error -->
        <?php
        if (isset($_SESSION['success'])) {
            echo '<span class="ole"> Article guardat correctament!</span>';
            unset($_SESSION['success']);

        } elseif (isset($_SESSION['failure'])) {
            echo '<span class="ole"> Algo no ha funcionat com s\'esperaba</span>';
            unset($_SESSION['failure']);
        }
        
        ?>

        <!-- Mostrar errors si existeixen -->
        <?php
        if (isset($_SESSION['errors'])) {
            $errorCode = $_SESSION['errors'];

            // Comprovar si el codi d'error existeix en l'array d'errors
            if (isset($errorMessages[$errorCode])) {
                echo '<span class="noole">' . $errorMessages[$errorCode] . '</span>';
            }

            unset($_SESSION['errors']); // Esborrem l'error una vegada mostrat
        }
        ?>


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