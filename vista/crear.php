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
    <link rel="stylesheet" href="./styles/styles_crear.css">
</head>

<body>
    <h1>Crear nou element</h1>
    <form action="../controlador/save_edit.php" method="POST">
        <!-- Missatges d'èxit o error -->
        <?php
        // Mostrar missatges d'èxit o error
        if (isset($_SESSION['success'])) {
            echo '<span class="ole">' . $_SESSION['success'] . '</span>';
            unset($_SESSION['success']); // Limpiamos el mensaje después de mostrarlo
        }

        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo '<span class="noole">' . $error . '</span><br>';
            }
            unset($_SESSION['errors']); // Limpiamos los errores después de mostrarlos
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
    <a href="../index.php">Tornar</a>
</body>

</html>