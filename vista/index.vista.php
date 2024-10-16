<!-- Alexis Boisset -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor d'articles</title>
    <link rel="stylesheet" href="./vista/styles/styles.css">
</head>

<header>
<?php if (!isset($_SESSION['loggedin'])): ?>
        <!-- Opciones de logarse o registrar-se cuando no está logado -->
        <a href="./vista/login.vista.php" class="btn-login">Logar-se</a>
        <a href="./vista/register.view.php" class="btn-register">Enregistrar-se</a>
    <?php else: ?>
        <!-- Mensaje cuando el usuario ya está logado -->
        <p>Benvingut, <?php echo $_SESSION['username']; ?>!</p>
        <a ºhref="logout.php" class="btn-logout">Tancar sessió</a>
    <?php endif; ?>

</header>

<body>
    <h1>Gestió d'articles</h1>
    <ul>
        <!-- Enllaços per a gestionar els articles -->
        <li><a href="vista/crear.php">Crear nou element</a></li>
        <li><a href="vista/llistar.php">Consultar elements</a></li>
        <li><a href="vista/eliminar.php">Eliminar un element</a></li>
    </ul>

    <!-- Mostra els articles paginats -->
    <h2>Llista d'articles</h2>
    <?php if (count($articles) > 0): ?>
        <div class="articles">
            <?php foreach ($articles as $article): ?>
                <div class="article">
                    <h3><?= htmlspecialchars($article['titol']) ?></h3>
                    <p><?= htmlspecialchars($article['cos']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navegació de paginació -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">Anterior</a>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>">Següent</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>No hi ha articles disponibles.</p>
    <?php endif; ?>
</body>

</html>
